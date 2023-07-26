<?php

namespace App\Http\Repositories\Stock;

use App\Http\Actions\Inventory\Common;
use App\Http\Actions\Stock\StockModule;
use App\Models\Brand;
use App\Models\DiscountSubProduct;
use App\Models\Invoice;
use App\Models\Series;
use App\Models\Stock;
use App\Models\Style;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockRepository implements StockRepositoryInterface
{
    private $select_data = ['id', 'quantity', 'sub_product_id', 'floor_id'];
    // private $select_data = ['id', 'quantity','invoice_id', 'sub_product_id', 'floor_id'];

    public function queryList()
    {
        return \App\Models\FloorSubProduct::with(['sub_product.product.thing.series', 'sub_product.product.thing.brands', 'sub_product.product.thing.sub_categories.category'])
        ->orderBy('id','desc')
        ->sortBySubProduct()
            ->where('quantity', '!=', 0)
            ->select($this->select_data);
    }
    function list($request) {
        $stocks = $this->queryList();
        if ($request->search_input != null || $request->search_input != "") {
            $stocks->bySubProduct($request);
        }
        if ($request->sub_category_id != null || $request->sub_category_id != "") {
            $stocks->byModel($request->sub_category_id, 'sub_product.product.thing.sub_categories');
        }

        if ($request->brand_id != null || $request->brand_id != "") {
            $stocks->byModel($request->brand_id, 'sub_product.product.thing.brands');
        }
        if ($request->sereis_id != null || $request->series_id != "") {
            $stocks->byModel($request->series_id, 'sub_product.product.thing.series');
        }
        if ($request->floor_id != null || $request->floor_id != "") {
            $stocks->byModel($request->floor_id, 'floor');
        }
        if (Auth::user()->hasPermission('admin-management')) {
            if ($request->inventory_id != null || $request->inventory_id != "") {
                $stocks->byModel($request->inventory_id, 'floor.shelf.inventory');
            }
        }
        if (Auth::user()->hasPermission('inventory-management')) {
            $stocks->byModel($request->inventory_id, 'floor.shelf.inventory');
        }
        $stocks = $stocks
            ->selectRaw('sum(quantity) as qty')
            ->groupBy('sub_product_id', 'floor_id')
            ->get()
            ->groupBy('sub_product_id');
        return (new Common())->getTotalQtyBySubproduct($stocks);
    }
    public function createOrUpdate($request)
    {
        $json_data = JsonDecode($request->stocks);
        $data = $request->all();
        DB::beginTransaction();
        try {
            if (!isset($request->id)) {
                $data['id'] = null;
            }
            $invoice = Invoice::create([
                'invoice_no' => $request->invoice_no,
                'supplier_id' => $request->supplier_id,
            ]);
            if ($invoice) {
                foreach ($json_data as $d) {
                    $data['floor_id'] = $d->floor_id;
                    $data['sub_product_id'] = $d->sub_product_id;
                    $data['invoice_id'] = $invoice->id;
                    $data['quantity'] = $d->quantity;
                    Stock::updateOrCreate(
                        ['id' => $data['id']],
                        $data
                    );
                    (new StockModule())->actionStocks($d, 'add');
                }
            }
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        // return $this->details($brand);
    }

    public function editStock($request){
        $stocks=Stock::where('sub_product_id',$request->sub_product_id)
        ->where('floor_id',$request->floor_id)->get();
        foreach($stocks as $stock){
            $stock->inventory=$stock->floor->shelf->inventory;
        }
        return $stocks;
    }
    public function saveStock($request){
        // $stock=Stock::find($stock_id);
        // $stock->inventory=$stock->floor->shelf->inventory;
        // return $stock;
    }

    public function getStockBySubProduct($request)
    {
        $stocks = $this->queryList()
            ->byModel($request->inventory_id, 'floor.shelf.inventory')
            ->bySubProduct($request)
            ->selectRaw('sum(quantity) as qty')
            ->groupBy('sub_product_id', 'floor_id')->get()
            ->groupBy('sub_product_id');
        return (new Common())->getTotalQtyBySubproduct($stocks);
    }
    public function getSubProductInStock($request)
    {
        $stocks = $this->queryList()
            ->bySubProduct($request)
            ->selectRaw('sum(quantity) as qty')
            ->groupBy('sub_product_id')->get();
        $sub = [];
        foreach ($stocks as $stock) {
            $stock->sub_product->quantity = $stock->qty;
            $sub[] = $stock->sub_product;
        }
        return $sub;
    }

    #updated discount moduel
    public function getSubProductBySeriesAndBrand($request)
    {
        $stocks = $this->queryList();
        if ($request->type == 'product') {
            $stocks->subProductBySeriesAndBrand($request);
        }
        if ($request->type == 'style') {
            return $this->getStyleBySeriesAndBrand($request);
        }
        $stocks = $stocks->selectRaw('sum(quantity) as qty')
            ->groupBy('sub_product_id')->get();
        $sub = [];
        foreach ($stocks as $stock) {
            $stock->sub_product->quantity = $stock->qty;
            $sub[] = $stock->sub_product;
        }
        return $sub;
    }

    public function getStyleBySeriesAndBrand($request)
    {
        $with = 'thing.' . $request->promotion_type;
        $styles = Style::with('products', 'name_translations', 'description_translations', 'thing.series', 'thing.brands', 'thing.categories')
            ->orderBy('id', 'desc')
            ->getType('style')
            ->whereHas($with, function ($q) use ($request) {
                $q->where('id', $request->promotion_category);
            })
            ->get();
        foreach ($styles as $style) {
            $total_price = 0;
            foreach ($style->products as $p) {
                // $p->sub_products=$p->sub_products;
                $price = 0;
                foreach ($p->sub_products as $s) {
                    $price += $s->product_prices->price;
                }
                $total_price += $price;
            }
            $style->total_price = $total_price;
        }
        return $styles;
    }
    #updated discount feature
    public function getDiscountSubProductInStock($request)
    {
        $discount_sub_products = DiscountSubProduct::with('discount', 'sub_product', 'discount.discount_type')
            ->bySubProduct($request)
            ->beforeEndDate()
            ->get();
        $sub = [];
        foreach ($discount_sub_products as $stock) {
            $stock->sub_product->discount = $stock->discount;
            $stock->sub_product->discount_sub_product_id = $stock->id;
            $sub[] = $stock->sub_product;
        }
        return $sub;
    }
    public function getItemWithTypeInStock($request)
    {
        switch ($request->type) {
            case 'product':
                return $this->getSubProductInStock($request);
                break;
            case 'style':
                return $this->getStyleInStock($request);
                break;
            case 'brand':
                return $this->getBrandInStock($request);
                break;
            case 'series':
                return $this->getSeriesInStock($request);
                break;
            case 'sub_category':
                return $this->getSubCategoriesInStock($request);
                break;
        }
    }

    public function getStyleInStock($request)
    {
        $data = $request;
        $styles = Style::with(['products', 'thing.brands'])
            ->getType($request->type)
            ->bySearchSku($request)
            ->get();
        $styles_arr = [];
        $data->search_input = "";
        $sub_products = $this->getSubProductInStock($data);
        foreach ($sub_products as $sub) {
            foreach ($sub->product->styles as $st) {
                array_push($styles_arr, $st);
            }
        }
        $styles_id = collect($styles_arr)->unique('id');
        $style_in_stock= $styles->intersect($styles_id);
        foreach ($style_in_stock as $st) {
            $style_sub_products = [];
            foreach ($st->products as $p) {
                foreach ($p->sub_products as $sub) {
                    array_push($style_sub_products, $sub);
                }
            }
            $st->sub_products = $style_sub_products;
        }
        return $style_in_stock;
    }

    public function getBrandInStock($request)
    {
        $brands = Brand::orderBy('id', 'desc')
            ->bySearchSku($request)
            ->get();
        $request->search_input = "";
        $sub_products = $this->getSubProductInStock($request);
        $brands_in_stock = [];
        $b_subs=[];
        foreach ($sub_products as $k => $sub) {
            foreach ($sub->product->thing->brands as $key => $b) {
                array_push($brands_in_stock, $b);
                array_push($b_subs, $sub);
            }
        }

        $unique_brands_in_stock = collect($brands_in_stock)->unique('id');

        $unique_brands = $brands->intersect($unique_brands_in_stock);
        foreach ($unique_brands as $b) {
            $brand_sub_products = [];
            foreach ($b->things as $thing) {
                if ($thing->thingable->sub_products) {
                    $sub_products_of_brands=$thing->thingable->sub_products->intersect(collect($b_subs));
                    // array_push($brand_sub_products,$s);
                    foreach ($sub_products_of_brands as $sub) {
                        array_push($brand_sub_products, $sub);
                    }
                }
            }
            $b->sub_products = $brand_sub_products;
        }
        return $unique_brands;
    }
    public function getSeriesInStock($request)
    {
        $series = Series::orderBy('id', 'desc')
            ->bySearchSku($request)
            ->get();
        $request->search_input = "";
        $sub_products = $this->getSubProductInStock($request);
        $series_in_stock = [];
        $b_subs=[];
        foreach ($sub_products as $k => $sub) {
            foreach ($sub->product->thing->series as $key => $b) {
                array_push($series_in_stock, $b);
                array_push($b_subs, $sub);
            }
        }
        $unique_series_in_stock = collect($series_in_stock)->unique('id');
        $unique_series = $series->intersect($unique_series_in_stock);
        foreach ($unique_series as $b) {
            $series_sub_products = [];
            foreach ($b->things as $thing) {
                // return $thing->thingable->sub_products;
                if ($thing->thingable->sub_products) {
                    $sub_products_of_brands=$thing->thingable->sub_products->intersect(collect($b_subs));
                    foreach ($sub_products_of_brands as $sub) {
                            array_push($series_sub_products, $sub);
                    }
                }
            }
            $b->sub_products = $series_sub_products;
        }
        return $unique_series;
    }
    public function getSubCategoriesInStock($request)
    {
        $sub_categories = SubCategory::orderBy('id', 'desc')
            ->bySearchSku($request)
            ->get();
        $request->search_input = "";
        $sub_products = $this->getSubProductInStock($request);
        $sub_categories_in_stock = [];
        $b_subs=[];
        foreach ($sub_products as $k => $sub) {
            foreach ($sub->product->thing->sub_categories as $key => $b) {
                array_push($sub_categories_in_stock, $b);
                array_push($b_subs, $sub);
            }
        }
        $unique_sub_categories_in_stock = collect($sub_categories_in_stock)->unique('id');
        $unique_sub_categories = $sub_categories->intersect($unique_sub_categories_in_stock);
        foreach ($unique_sub_categories as $b) {
            $sub_categories_sub_products = [];
            foreach ($b->things as $thing) {
                if ($thing->thingable->sub_products) {
                    $sub_products_of_brands=$thing->thingable->sub_products->intersect(collect($b_subs));
                    foreach ($sub_products_of_brands as $sub) {
                        array_push($sub_categories_sub_products, $sub);
                    }
                }
            }
            $b->sub_products = $sub_categories_sub_products;
        }
        return $unique_sub_categories;
    }
}
