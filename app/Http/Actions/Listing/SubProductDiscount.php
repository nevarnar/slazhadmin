<?php

namespace App\Http\Actions\Listing;

use App\Http\Actions\Inventory\Common;
use App\Models\Discount;

class SubProductDiscount
{
    public function run($sub_product){
        $sub_product_discounts = Discount::orderBy('id')
            ->select('id','end_date','discount_value','min_buying_amount','discount_type_id','is_flash_sale','discountable_id')
            ->withSubProduct($sub_product->id,'sub_product')->get();
        $is_delivery_free =  $sub_product_discounts->contains('discount_type_id' , 3);  // 3 is for delivery free
        $size = new \stdClass();
        $size->id = $sub_product->size->id;
        $size->name =  $sub_product->size->name;
        $size->is_delivery_free =  $is_delivery_free;
        $size->discount = $this->getDiscount($sub_product_discounts);
        $size->price = $sub_product->product_prices->price;
        $size->sub_product_id = $sub_product->id;
        $size->stock_quantity = (new Common())->getsubProductQuantity($sub_product->id);
        return $size;
    }

    public function getDiscount($sub_product_discounts)
    {
        $max_discount = $sub_product_discounts->where('discount_type_id','<>',3)->first();
        if($max_discount){
            UnsetData($max_discount,['is_flash_sale','end_date', 'discount_type','discountable_id','discount_type_id']);
        }
        return $max_discount;
    }
}
