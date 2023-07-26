<?php

namespace App\Http\Actions\Listing;

use App\Models\Discount;

class StyleListing
{
    public function card($style)
    {
        $price = 0;
        $style->is_already_favourite = false;
        $products=[];
        foreach ($style->products as $product) {
            $products [] =  (new ProductsInStyle())->card($product);
            $price += $product->price;
        }
        $style->price = $price;
        $style->style_products=$products
        (new StyleDiscount())->run($style);
        // (new StyleDetails())->stylePriceAndProducts($style);
        $style->feature_photo = $style->feature_photo();
        $user = UserData();
        if ($user) {
            $user_id = $user->id;
            $style->is_already_favourite = $style->favouriteUser->contains($user_id);
        }
        UnsetData($style, ['thing', 'products']); 
        return $style->only('id','is_already_favourite', 'price','discount','is_delivery_free', 'feature_photo', 'name_translations');
    }

}
