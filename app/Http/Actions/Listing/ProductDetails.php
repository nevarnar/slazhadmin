<?php

namespace App\Http\Actions\Listing;

use App\Models\Product;
use App\Models\OrderItem;
use App\Models\SubProduct;
use App\Http\Actions\Inventory\Common;

class ProductDetails
{
    public function run($product_id)
    {
        $product = $this->getProductById($product_id);
        $this->updateViewCount($product);
        $this->checkUserAction($product);
        $this->getProductBrand($product);
        $this->getProductVariations($product);
        $this->getAvailableFloorOfProduct($product);
        return $this->getSizeAvailable($product);
    }

    protected function getProductById($product_id)
    {
        $product = Product::where('id', $product_id)->select('id','view_count')
            ->with('description_translations:id,name,language_code,description_translationable_id',
                'thing.brands:id', 'sub_products', 'product_photos')->first();
        if ($product == null) responseStatus('Product is not found', 404);
        return $product;
    }

    protected function updateViewCount($product){
       $product->view_count = ++$product->view_count;
       $product->save();

    }

    protected function checkUserAction($product)
    {
        $product->is_already_bought = false;
        $product->is_already_reviewed = false;
        $product->is_already_favourite = false;
        $user = UserData();
        if ($user) {
            $user_id = $user->id;
            $product->is_already_bought = $this->checkUserHaveBoughtProduct($product , $user_id);
            $product->is_already_reviewed = collect($product->reviews)->contains('user_id', $user_id);
            $product->is_already_favourite = $product->favouriteUser->contains($user_id);
        }
        return $product;
    }

    protected function getProductBrand($product)
    {
        $brands = $product->thing->brands;
        foreach ($brands as $brand) {
            $product->brand = $brand->name_translations;
        }
        return $product;
    }

    protected function getProductVariations($product)
    {
        $sub_variations = $product->thing->sub_variations;
        $sub_vars = [];
        foreach ($sub_variations as $sub_variation) {
            $variation = new \stdClass();
            $variation->variation = $sub_variation->variation->name_translations;
            $variation->sub_variation = $sub_variation->name_translations;
            $sub_vars[] = $variation;
        }
        $product->product_variation = $sub_vars;
        return $product;
    }

    protected function getSizeAvailable($product)
    {

        $sub_products_by_color = $this->getSubProductsByColor($product->id);
        $available_colors = [];
        foreach ($sub_products_by_color as $sub_products) {
            $available_colors [] = $this->getAvailableColors($product, $sub_products);
        }
        $product->avaliable_colors = $available_colors;
        return $product;
    }

    protected function getSubProductsByColor($product_id)
    {
        return SubProduct::where([['product_id', $product_id], ['is_available', true]])
            ->select('id', 'size_id', 'color_id')
            ->get()
            ->groupBy('color_id')
            ->values();
    }

    protected function getAvailableColors($product, $sub_products)
    {
        $photos = $this->getSubProductPhotos($product);
        $color_product_photo = [];
        $color = $sub_products[0]->color;
        $color->name = $sub_products[0]->color->name_translations[0]->name;
        foreach ($photos as $photo) {
            if ($photo->color_id == $color->id) {
                $color_product_photo[] = $photo;
            }
        }
        $available_sizes = [];
        foreach ($sub_products as $sub_product) {
            $size = (new SubProductDiscount())->run($sub_product);
            $size->available_floors = (new Common())->getAvailableFloorOfInventoryBySubProduct($sub_product->id);
            #for sale return product 
            #end 
            $available_sizes [] = $size;
            UnsetData($sub_product->size, ['unit_type_id', 'created_at', 'updated_at', 'unit_type']);
            UnsetData($sub_product, ['product', 'color', 'size', 'product_prices', 'genders', 'seasons', 'taxes']);
        }
        $color->photos = $color_product_photo;
        $color->available_sizes = $available_sizes;
        UnsetData($color, ['sku_name', 'color_code', 'name_translations', 'created_at', 'updated_at']);
        UnsetData($product, ['genders', 'seasons', 'taxes', 'sub_products', 'thing', 'product_photo', 'sub_product_photos', 'reviews', 'favourite_user']);

        return $color;
    }

    protected function getSubProductPhotos($product)
    {
        return collect($product->sub_product_photos);
    }

    protected function checkUserHaveBoughtProduct($product, $user_id)
    {
        foreach ($product->sub_products as $sub) {
            $sub_id[] = $sub->id;
        }
        if (!empty($sub)) {
            $order_item = OrderItem::whereHas('order', function ($q) use ($user_id) {
                $q->where('status', 'confirmed')
                    ->where('user_id', $user_id);
            })
                ->where('orderable_type', 'sub_product')
                ->whereIn('orderable_id', $sub_id)
                ->first();
            if ($order_item) {
                return true;
            }
        }
        return  false;
    }

    public function getAvailableFloorOfProduct($product){
        $product->inventories= (new Common())->getAvailableFloorOfProduct($product->sub_products);
    }

}
