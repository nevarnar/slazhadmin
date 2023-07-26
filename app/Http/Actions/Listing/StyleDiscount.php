<?php

namespace App\Http\Actions\Listing;

use Carbon\Carbon;
use App\Models\Discount;

class StyleDiscount
{
    public function run($style)
    {
        $discounts = Discount::orderBy('id')
            ->select('id', 'end_date', 'quantity', 'discount_value', 'min_buying_amount', 'discount_type_id', 'is_flash_sale', 'discountable_id')
            ->withSubProduct($style->id, 'style')->get();
        $is_delivery_free =  $discounts->contains('discount_type_id' , 3);  // 3 is for delivery free
        $style->is_delivery_free =  $is_delivery_free;
        $style->discount = (new SubProductDiscount())->getDiscount($discounts);
    }
}
