<?php

namespace App\Http\Actions\Inventory;

use App\Models\FloorSubProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use stdClass;

class Common
{
    public function setSubProductPhoto($data)
    {
        $product=\App\Models\Product::find($data->product_id);
        if ($product->sub_product_photos->isNotEmpty()) {
            $product->sub_product_photos->filter(function ($v, $k) use ($data,$product) {
                if ($data->color->id == $v->color_id) {
                     return $data->photo = $v;
                }
            });
        }
        // dd($data->product);
        // if ($data->product != null) {
        //     if ($data->product->sub_product_photos->isNotEmpty()) {
        //         $data->product->sub_product_photos->filter(function ($v, $k) use ($data) {
        //             if ($data->color->id == $v->color_id) {
        //                 return $data->photo = $v;
        //             }
        //         });
        //     }
        // }

    }
    public function getTotalQtyBySubproduct($stocks)
    {
        $data = array();
        if ($stocks->isNotEmpty()) {
            foreach ($stocks as $k => $stock) {
                $floor_arr = [];
                foreach ($stock as $key => $s) {
                    (new Common())->setSubProductPhoto($s->sub_product); #match sub product photo with sub product id
                    $stock[$key]->floor->quantity = $s->quantity;
                    $stock[$key]->floor->inventory_name = $s->floor->shelf->inventory->name_translations[0]->name;
                    #for defect only to validate quantity
                    $stock[$key]->floor->defect_quantity = $s->quantity - $this->getDefectQtyBySubProductAndFloor($s->sub_product_id, $s->floor->id);
                    $stock[$key]->floor->transfer_quantity = $this->getTransferQtyBySubProductAndFloor($s->sub_product_id, $s->floor->id);
                    array_push($floor_arr, $s->floor);
                }
                $unique_stock = $stocks[$k]->unique('sub_product_id');
                $unique_stock[0]->floors = $floor_arr;
                $unique_stock[0]->total_quantity = collect($floor_arr)->sum('defect_quantity') - collect($floor_arr)->sum('transfer_quantity'); #total quanty at a floor per sub product
                array_push($data, $unique_stock);
            }
            $singleArray = [];
            foreach ($data as $childArray) {
                foreach ($childArray as $value) {
                    $singleArray[] = $value;
                }
            }
            return $singleArray;
        }
    }

    protected function getFloorQty($data)
    {
        return DB::table('floor_sub_product')->where([
            ['sub_product_id', $data->sub_product_id],
            ['floor_id', $data->floor_id],
        ])->first()->quantity;
    }

    protected function getDefectQtyBySubProductAndFloor($sub_id, $floor_id)
    {
        $defects = \App\Models\Defect::where('sub_product_id', $sub_id)
            ->where('status', false)
            ->where('floor_id', $floor_id)
            ->get();
        return $defects->sum('quantity');
    }
    protected function getTransferQtyBySubProductAndFloor($sub_id, $floor_id)
    {
        $transfers = \App\Models\SubProductTransfer::where('sub_product_id', $sub_id)
            ->where('floor_id', $floor_id)
            ->whereHas('transfer', function ($q) {
                $q->where('status', 'pending');
            })->get();
        return $transfers->sum('quantity');
    }

    public function floorByInventory($inventory_id)
    {
        $shelves = \App\Models\Shelf::where('inventory_id', $inventory_id);
        if (Route::currentRouteName() !== 'floor_list_by_inventory') {
            $shelves->withTrashed();
        }
        $shelves = $shelves->get();
        $floor_arr = [];
        if ($shelves) {
            foreach ($shelves as $shelf) {
                foreach ($shelf->floors as $f) {
                    array_push($floor_arr, $f);
                }
            }
        }
        return $floor_arr;
    }

    public function checkStockExistToDelete($model, $relation)
    {

        $check_sub_products = \App\Models\FloorSubProduct::byModel($model->id, $relation)->get();
        if ($check_sub_products->isNotEmpty() && $check_sub_products->sum('quantity') > 0) {
            return responseStatus('Error!Inventory has many products.Please transfer first', 402);
        }
        return true;
    }
    public function getsubProductQuantity($sub_product_id)
    {
        $sub_product = \App\Models\FloorSubProduct::with(['sub_product.product.thing.series', 'sub_product.product.thing.brands'])->sortBySubProduct()
            ->where('sub_product_id', $sub_product_id)
            ->where('quantity', '!=', 0)
            ->selectRaw('sum(quantity) as qty')
            ->first();
        if ($sub_product) {
            return $sub_product->qty;
        }
        return 0;
    }

    #sub product in stock
    public function queryList()
    {
        return \App\Models\FloorSubProduct::with(['sub_product.product.thing.series', 'sub_product.product.thing.brands', 'sub_product.product.thing.sub_categories.category'])->sortBySubProduct()
            ->where('quantity', '!=', 0)
            ->select(['id', 'quantity', 'sub_product_id', 'floor_id']);
    }

    public function getSubProductInStock()
    {
        $stocks = $this->queryList()
            ->selectRaw('sum(quantity) as qty')
            ->groupBy('sub_product_id')->get();
        $sub = [];
        foreach ($stocks as $stock) {
            $stock->sub_product->quantity = $stock->qty;
            $sub[] = $stock->sub_product;
        }
        return $sub;
    }

    public function getAvailableSubProductOfInventory($sub_product_id)
    {

        $floors = DB::table('floor_sub_product')
            ->where('sub_product_id', $sub_product_id)
            ->selectRaw('inventories.id,name_translations.name,sum(quantity-floor_sub_product.order_quantity) as qty')
            ->join('floors', 'floors.id', '=', 'floor_sub_product.floor_id')
            ->join('shelves', 'shelves.id', '=', 'floors.shelf_id')
            ->join('inventories', 'inventories.id', '=', 'shelves.inventory_id')
            ->join('name_translations', 'name_translations.name_translationable_id', '=', 'inventories.id')
            ->where('name_translations.name_translationable_type', 'inventory')
            ->where('name_translations.language_code', 'en')
            ->groupBy('inventories.id')
            ->get();
        return $floors;
    }

    // ->join('name_translations','name_translations.name_translationable_id','=','inventories.id')
    // ->where('name_translations.name_translationable_type','inventory')

    public function getInventoryByAvailableFloorOfSubProduct($order_items)
    {
        $inventories =$this->getInventories();
        foreach ($inventories as $i=>$inventory) {
            // $floors=DB::table('floor_sub_product')
            // ->where('sub_product_id',$sub_product_id)
            // ->selectRaw('floors.name,floors.id,floor_sub_product.quantity-floor_sub_product.order_quantity as qty')
            // ->join('floors', 'floors.id', '=', 'floor_sub_product.floor_id')
            // ->whereHas('floor.shelf.inventory',function($q){
            //     $q->where('id',1);
            // })
            // ->get();
            $available_inv_array=[];
            foreach ($order_items as $k => $oi) {
                $floors=$this->getAvailableFloorBySubProductOfInventory($oi->sub_product_id,$inventory->id);
                    // $floors = FloorSubProduct::where('sub_product_id', $oi->sub_product_id)
                    //     ->selectRaw('floors.name,floors.id,floor_sub_product.quantity-floor_sub_product.order_quantity as qty')
                    //     ->join('floors', 'floors.id', '=', 'floor_sub_product.floor_id')
                    //     ->whereHas('floor.shelf.inventory', function ($q) use ($inventory) {
                    //         $q->where('id', $inventory->id);
                    //     })
                    //     ->get();
                    $available_inv = new stdClass();
                    $available_inv->item_id = $oi->item_id;
                    $available_inv->sub_product_id = $oi->sub_product_id;
                    $available_inv->type = $oi->type;
                    $available_inv->floors = $floors;
                    $available_inv_array[]=$available_inv;
                    // $inventory->item_id=$oi->id;
                    // $inventory->type=$oi->orderable_type;
                    // $inventory->floors=$floors;
            }
            $inventory->available_floors_by_sub_product = $available_inv_array;
        }
        
        return $inventories;
    }

    public function getInventories(){
        return \App\Models\Inventory::orderBy('id', 'asc')->get();
    }

    public function getAvailableFloorBySubProductOfInventory($sub_product_id,$inventory_id){
        return FloorSubProduct::where('sub_product_id', $sub_product_id)
        ->selectRaw('floors.name,floors.id,floor_sub_product.quantity-floor_sub_product.order_quantity as qty')
        ->join('floors', 'floors.id', '=', 'floor_sub_product.floor_id')
        ->whereHas('floor.shelf.inventory', function ($q) use ($inventory_id) {
            $q->where('id', $inventory_id);
        })
        ->get();
    }

    public function getAvailableFloorOfInventoryBySubProduct($sub_product_id)
    {
        // if (Auth::user()->hasPermission('inventory-management')) {
            $floors = DB::table('floor_sub_product')
                ->where('sub_product_id', $sub_product_id)
                ->selectRaw('floors.name,floors.id,floor_sub_product.quantity-floor_sub_product.order_quantity as qty')
                ->join('floors', 'floors.id', '=', 'floor_sub_product.floor_id')->get();
            return $floors;
        // }
        // if (Auth::user()->hasPermission('order-management')) {
        //     $inventories = \App\Models\Inventory::orderBy('id', 'desc')->get();
        //     foreach ($inventories as $inventory) {
        //         // $floors=DB::table('floor_sub_product')
        //         // ->where('sub_product_id',$sub_product_id)
        //         // ->selectRaw('floors.name,floors.id,floor_sub_product.quantity-floor_sub_product.order_quantity as qty')
        //         // ->join('floors', 'floors.id', '=', 'floor_sub_product.floor_id')
        //         // ->whereHas('floor.shelf.inventory',function($q){
        //         //     $q->where('id',1);
        //         // })
        //         // ->get();
        //         $floors = FloorSubProduct::where('sub_product_id', $sub_product_id)
        //             ->selectRaw('floors.name,floors.id,floor_sub_product.quantity-floor_sub_product.order_quantity as qty')
        //             ->join('floors', 'floors.id', '=', 'floor_sub_product.floor_id')
        //             ->whereHas('floor.shelf.inventory', function ($q) {
        //                 $q->where('id', 1);
        //             })
        //             ->get();
        //         $inventory->floors = $floors;
        //     }
        //     return $inventories;
        // }
    }

    public function getAvailableFloorOfProduct($sub_products){
        $inventories = \App\Models\Inventory::orderBy('id', 'asc')->get();
        foreach($inventories as $inventory){
            foreach($sub_products as $k=>$sub_product){
                $available_floor_of_sub_product[$k]=new stdClass();
                $available_floor_of_sub_product[$k]->sub_product_id=$sub_product->id;
                $available_floor_of_sub_product[$k]->available_floor=$this->getAvailableFloorBySubProductOfInventory($sub_product->id,$inventory->id);
            }
            $inventory->available_floor_of_sub_product=$available_floor_of_sub_product;
        }
        return $inventories;
    }

    public function getFloorSubProduct($floor_id, $sub_id)
    {
        return FloorSubProduct::where('floor_id', $floor_id)
            ->where('sub_product_id', $sub_id)->first();
    }

    public function setCouponForm($coupon)
    {
        $min_list = new stdClass();
        $limitation_list = new stdClass();

        // $collection=$style=$sub_category=$series=$brand=$product=[];
        // $limitation_collection=$limitation_style=$limitation_sub_category=$limitation_series=$limitation_brand=$limitation_product=[];

        if ($coupon->min_buying_condition->isNotEmpty()) {
            foreach ($coupon->min_buying_condition as $min) {
                $min->buyable_type == 'brand' ?
                $min_list->brand = $min->buyable_id : $min_list->brand = null;
                $min->buyable_type == 'product' ?
                $min_list->product = $min->buyable_id : $min_list->product = null;
                $min->buyable_type == 'series' ?
                $min_list->series = $min->buyable_id : $min_list->series = null;
                $min->buyable_type == 'collection' ?
                $min_list->collection = $min->buyable_id : $min_list->collection = null;
                $min->buyable_type == 'style_name' ?
                $min_list->stylist = $min->buyable_id : $min_list->stylist = null;
                $min->buyable_type == 'sub_category' ?
                $min_list->sub_category = $min->buyable_id : $min_list->sub_category = null;
                // if($min->buyable_type=='brand'){
                //     array_push($brand,$min->buyable_id);
                // }
                // if($min->buyable_type=='product'){
                //     array_push($product,$min->buyable_id);

                // }
                // if($min->buyable_type=='series'){
                //     array_push($series,$min->buyable_id);

                // }
                // if($min->buyable_type=='collection'){
                //     array_push($collection,$min->buyable_id);
                // }
                // if($min->buyable_type=='sub_category'){
                //     array_push($sub_category,$min->buyable_id);
                // }
                // if($min->buyable_type=='style'){
                //     array_push($style,$min->buyable_id);
                // }
            }
            // $min_list->brand=$brand;
            // $min_list->product=$product;
            // $min_list->series=$series;
            // $min_list->collection=$collection;
            // $min_list->sub_category=$sub_category;
            // $min_list->style=$style;
        } else {
            $min_list = null;
        }

        if ($coupon->coupon_limitation->isNotEmpty()) {
            foreach ($coupon->coupon_limitation as $limit) {
                $limit->limitable_type == 'brand' ? $limitation_list->brand = $limit->limitable_id : $limitation_list->brand = null;
                $limit->limitable_type == 'product' ? $limitation_list->product = $limit->limitable_id : $limitation_list->product = null;
                $limit->limitable_type == 'series' ? $limitation_liseries = $limit->limitable_id : $limitation_list->series = null;
                $limit->limitable_type == 'collection' ? $limitation_list->collection = $limit->limitable_id : $limitation_list->collection = null;
                $limit->limitable_type == 'style_name' ? $limitation_list->stylist = $limit->limitable_id : $limitation_list->stylist = null;
                $limit->limitable_type == 'sub_category' ? $limitation_list->sub_category = $limit->limitable_id : $limitation_list->sub_category = null;
                // if($limit->limitable_type=='brand'){
                //     array_push($limitation_brand,$limit->limitable_id);
                // }
                // if($limit->limitable_type=='product'){
                //     // array_push($limitation_product,$limit->limitable_id);
                // }
                // if($limit->limitable_type=='series'){
                //     array_push($limitation_series,$limit->limitable_id);

                // }
                // if($limit->limitable_type=='collection'){
                //     array_push($limitation_collection,$limit->limitable_id);
                // }
                // if($limit->limitable_type=='sub_category'){
                //     array_push($limitation_sub_category,$limit->limitable_id);

                // }
                // if($limit->limitable_type=='style'){
                //     array_push($limitation_style,$limit->limitable_id);
                //     $limitation_list->style=$limit->limitable_id;
                // }
            }
            // $limitation_list->brand=$limitation_brand;
            // $limitation_list->product=$limitation_product;
            // $limitation_list->series=$limitation_series;
            // $limitation_list->collection=$limitation_collection;
            // $limitation_list->sub_category=$limitation_sub_category;
            // $limitation_list->style=$limitation_style;
        } else {
            $limitation_list = null;
        }
        $coupon->min_buying_condition_list = $min_list;

        $coupon->limitation_list = $limitation_list;

        UnsetData($coupon, ['coupon_limitation', 'min_buying_condition', 'coupon_discount_type_id', 'coupon_type_id']);
        return $coupon;
    }

}
