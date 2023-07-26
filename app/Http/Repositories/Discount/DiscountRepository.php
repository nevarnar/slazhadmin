<?php

namespace App\Http\Repositories\Discount;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\Discount;
use App\Models\DiscountType;
use App\Models\FlashSaleStyle;
use Illuminate\Support\Facades\DB;
use App\Models\FlashSaleSubProduct;
use App\Http\Actions\Inventory\Common;
use App\Http\Actions\Listing\FlashSale;
use Illuminate\Support\Facades\Request;

class DiscountRepository implements DiscountInterface
{
    function list($request) {
        $query = Discount::with(['discount_type', 'discountable'])->orderBy('id', 'DESC');
        if ($request->discount_type_id != null || $request->discount_type_id != "") {
            $query->byDiscountType($request->discount_type_id);
        }
        return $query->get();
    }
    public function details($discount)
    {
        $discount->discount_type = $discount->discount_type;
        $discount->discount_item = $discount->discountable;
        $discount->discountable_type == 'style' ? $discount->discount_item->thing->brands = $discount->discountable->thing->brands :
        $discount->discount_item->product->thing->brands = $discount->discountable->product->thing->brands;
        return $discount;
    }

    public function getSubProductQuantity($sub_product_id)
    {
        $sub_product = \App\Models\FloorSubProduct::with(['sub_product.product.thing.series', 'sub_product.product.thing.brands'])->sortBySubProduct()
            ->where('sub_product_id', $sub_product_id)
            ->where('quantity', '!=', 0)
            ->selectRaw('sum(quantity) as qty')
            ->first();
        if ($sub_product) {
            return $sub_product->qty;
        }
    }
    public function delete($discount)
    {
        return $discount->delete();
    }

    public function getDiscountType()
    {
        return DiscountType::orderBy('id', 'DESC')->get();
    }

    public function createDiscount($data, $items, $type)
    {
        foreach ($items as $i) {
            if (isset($i->old_discount_id)) {
                $data['id'] = $i->old_discount_id;
            }
            $data['discountable_type'] = $type;
            $data['discountable_id'] = $i->id;
            Discount::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
        }
    }

    public function createOrUpdate($request)
    {
        $sub_products = json_decode($request->sub_products);
        $styles = json_decode($request->styles);
        $update_discount_items = json_decode($request->update_discount_items);
        $data = $request->all();
        DB::beginTransaction();
        try {
            if (!isset($request->id)) {
                $data['id'] = null;
            }
            $data['discount_value'] = $request->amount;
            $data['quantity']= $request->is_unlimited === "true"? null : $request->quantity;
            $data['start_date'] = convertDateFormat($data['start_date']);
            $data['end_date'] =convertDateFormat($data['end_date']);

            if (!$request->id) {
                    if (!empty($styles)) {
                        $this->createDiscount($data, $styles, 'style');
                    }
                    if (!empty($sub_products)) {
                        $sub_products = collect($sub_products)->unique('id');
                        $this->createDiscount($data, $sub_products, 'sub_product');
                    }
                    if (!empty($update_discount_items)) {
                        $update_discount_items = collect($update_discount_items)->unique('id');
                        $this->createDiscount($data, $update_discount_items, 'sub_product');
                    }
            } else {
                Discount::updateOrCreate(
                    ['id' => $data['id']],
                    $data
                );
            }
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
    }

    public function compareQty($sub_qty,$request){
        if($request->quantity!=null){
            if(((int)$sub_qty) < $request->quantity){
                return responseStatus('Quantity is not enough,Please Try another!', 402);
            }
        }else{
           if($sub_qty<1 ){
            return responseStatus('Quantity is empty at inventory,Please Try another!', 402);
           }
        }
    }
    public function checkQuantity($request){
        if($request->type==='sub_product'){
            $sub_qty=(new Common())->getsubProductQuantity($request->item['id']);
            $this->compareQty($sub_qty,$request);
            // if($request->quantity!=null){
            //     if($sub_qty < $request->quantity){
            //         return responseStatus('Quantity is not enough,Please Try another!', 402);
            //     }
            // }else{
            //    if($sub_qty<1 ){
            //     return responseStatus('Quantity is empty at inventory,Please Try another!', 402);
            //    }
            // }

        }else{

            foreach ($request->item['sub_products'] as $sub) {
                $sub_qty=(new Common())->getsubProductQuantity($sub['id']);
                $this->compareQty($sub_qty,$request);
            }
        }
    }

    public function validateDiscountSubProduct($request)
    {
        $this->checkQuantity($request);
        $start_date = convertDateFormat($request->start_date);
        $end_date = convertDateFormat($request->end_date);
        if ($request->type == 'style' || $request->type == 'sub_product') {
            if($request->type=='sub_product'){
                if((new FlashSaleSubProduct())->checkSubProductExists($request->item['id'],$start_date,$end_date)){
                    return responseStatus('Discount have been included at flashsale promotion,Please Try Another one!', 402);
                }
                if (((new Discount())->checkDiscountExists($request->item['id'], $request->type, $request->discount_type,$start_date,$end_date))) {
                    $data = [$request->item];
                    return responseStatus('Discount have been included in another discount promotion,Please Try Another one!', 402);
                }
            }
            if($request->type=='style'){
                if((new FlashSaleStyle())->checkStyleExists($request->item['id'],$start_date,$end_date)){
                    return responseStatus('Style have been included at flashsale promotion,Please Try Another one!', 402);
                }
            }
           
        } else {
            $data = [];
            foreach ($request->item['sub_products'] as $sub) {
                if((new FlashSaleSubProduct())->checkSubProductExists($request->item['id'],$start_date,$end_date)){
                    return responseStatus('Discount have been included at flashsale promotion,Please Try Another one!', 402);
                }
                if (((new Discount())->checkDiscountExists($sub['id'], null, $request->discount_type,$start_date,$end_date))) {
                    $discount = (new Discount())->getIdByType($sub['id'], null, $request->discount_type);
                    if ($discount) {
                        $sub['old_discount_id'] = $discount->id;
                    }
                    array_push($data, $sub);
                }
            }
            if (!empty($data)) {
                responseData('data', $data, 200);
            }

        }
        return [];
    }

    public function getDiscountByProduct($product_id){

        $product=Product::with(['sub_products'])->whereId($product_id)->first();
        if($product){
            foreach($product->sub_products as $sub){
                $d=Discount::with(['discount_type'])
                 ->orderBy('id')
                 ->select('id','end_date','quantity','discount_value','min_buying_amount','discount_type_id')
                 ->withSubProduct($sub->id,'sub_product')->get();
                 $sub->discounts=$d->isEmpty() ? null : $d;
             }
             return $product;
        }
        responseStatus("Product isn't found",404);
    }


    public function getFlashSaleItems($gender_id)
    {
        return (new FlashSale())->getFlashSaleSubProducts($gender_id);
    }

    public function getFlashSaleStyles($gender_id){
        return (new FlashSale())->getFlashSaleStyles($gender_id);
    }


}
