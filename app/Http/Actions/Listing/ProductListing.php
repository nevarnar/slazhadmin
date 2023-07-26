<?php

namespace App\Http\Actions\Listing;

use App\Models\Discount;
use App\Models\SubProductPhoto;

class ProductListing
{
    public function card($product)
    {
        $product->is_already_favourite = false;
        $product->avaliable_colors = $this->getSubProductData($product);
        $product->featured_photo = ($product->product_photo) ? $product->product_photo->name: null;
        $user = UserData();
        if ($user) {
            $user_id = $user->id;
            $product->is_already_favourite = $product->favouriteUser->contains($user_id);
        }
        UnsetData($product, ['thing', 'product_photo', 'sub_product_photos','sub_products']);
        return $product->only('id', 'price', 'is_already_favourite', 'featured_photo', 'avaliable_colors', 'name_translations', 'discount');
    }

    public function getDiscount($product_discount)
    {
        if ($product_discount) {
            $product_discount->now = now()->format('Y-m-d d:m:s');
            UnsetData($product_discount, ['id', 'discount_type', 'discount_type_id']);
        }
        return $product_discount;
    }

    public function getSubProductData($product)
    {
        $sub_products = $product->sub_products;
        $sub_products_by_colors = collect($sub_products)->groupBy('color_id')->values();
        $sub_products = [];
        foreach ($sub_products_by_colors as $sub_products_by_color) {
            $sub_product = new \stdClass();
            $sub_product->color_id = $sub_products_by_color[0]->color->id;
            $sub_product->color_icon = $sub_products_by_color[0]->color->icon;
            $sub_product->product_photo =
                SubProductPhoto::where([['product_id', $product->id],
                    ['color_id', $sub_products_by_color[0]->color->id],
                    ['type', 'front_view']])->pluck('name')->first();
            $sub_product->price = null;
            $sub_product->discount_value = null;
            $sub_product->is_delivery_free =  false;
            $sub_product_ids = $sub_products_by_color->pluck('id');
            $discounts = Discount::orderBy('id')
                ->select('id', 'quantity', 'discount_value', 'min_buying_amount',
                    'discount_type_id', 'discountable_id')
                ->withSubProducts($sub_product_ids, 'sub_product')->get();
            $product_discounts = collect($discounts);
            $max_discount = $product_discounts->sortByDesc('discount_value')->first();
            if($max_discount){
                $price =  collect($sub_products_by_color)->where('id','==',$max_discount->discountable_id)->pluck('product_prices.price')->first();
                $sub_product->is_delivery_free = $product_discounts->contains('discount_type_id', 3);// 3 is for delivery free
                $sub_product->price = $price;
                $sub_product->discount_value = $max_discount->discount_value;
            }
            else{
                $sub_product->price  =  collect($sub_products_by_color)->pluck('product_prices.price')->first();
            }
            $sub_products [] = $sub_product;
        }
        return collect($sub_products)->sortByDesc('discount_value')->values();
    }

    public function subCard($sub_product)
    {
        $sub_product->sub_color = $sub_product->color->icon;
        $sub_product->sub_size = $sub_product->size->name;
        $sub_product->price = $sub_product->product_prices->price;
        $sub_product->name_translations = $sub_product->product->name_translations;
        $sub_product->photo =
            SubProductPhoto::where([['product_id', $sub_product->product_id],
                ['color_id', $sub_product->color_id],
                ['type', 'front_view']])->pluck('name')->first();
        UnsetData($sub_product, ['color', 'size', 'product_prices', 'product']);
        return $sub_product->only('id', 'photo', 'price', 'sub_color','sub_size', 'name_translations');
    }
    public function getAvailable_colors($product)
    {
        $product_colors = collect($product->thing->colors);
        return $product_colors->pluck('icon')->all();
    }

    public function getColorsWithPhoto($product)
    {
        $product_colors = $product->thing->colors;
        $sub_products = [];
        foreach ($product_colors as $color) {
            $sub_product = new \stdClass();
            $sub_product->color_icon = $color->icon;
            $sub_product->product_photo =
                SubProductPhoto::where([['product_id', $product->id],
                    ['color_id', $color->id],
                    ['type', 'front_view']])->pluck('name')->first();
            $sub_products [] = $sub_product;
        }
        return $sub_products;
    }
}
