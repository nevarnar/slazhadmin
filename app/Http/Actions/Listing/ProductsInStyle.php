<?php

namespace App\Http\Actions\Listing;

use App\Models\Color;
use App\Models\SubProduct;
use App\Models\SubProductPhoto;

class ProductsInStyle
{
    public function card($product)
    {
        $product->brand_name = $product->thing->brands[0]->name_translations[0]->name;
        $product_color_id = $product->pivot->color_id;
        $color = Color::where('id', $product_color_id)->first();
        $product->color_name = $color->name_translations[0]->name;
        $product->color_icon = $color->icon;
        $product->photo = SubProductPhoto::where([['product_id', $product->id],
            ['color_id', $product_color_id], ['type', 'front_view']])
            ->pluck('name')->first();
        $sub_products = SubProduct::with('product_prices')->where([['product_id', $product->id], ['is_available', true],['color_id', $product_color_id]] )
            ->select('id', 'size_id','color_id')->orderBy('size_id')->get();
        $available_sizes = [];
        foreach ($sub_products as $sub_product) {
            $size = (new SubProductDiscount())->run($sub_product);
            $available_sizes[] = $size;
            UnsetData($sub_product->size, ['unit_type_id', 'created_at', 'updated_at', 'unit_type']);
            UnsetData($color, ['sku_name', 'color_code', 'name_translations', 'created_at', 'updated_at']);
            UnsetData($sub_product, ['product', 'color', 'size', 'product_prices', 'genders', 'seasons', 'taxes']);
        }
        $product->available_sizes = $available_sizes;
        unset($available_sizes);
        UnsetData($product, ['id','sku','price','is_available','created_at','updated_at','pivot','thing', 'product_photo', 'sub_product_photos','brands']);
        return $product;
    }
}
