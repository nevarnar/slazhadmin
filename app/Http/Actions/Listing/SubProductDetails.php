<?php

namespace App\Http\Actions\Listing;

use App\Http\Actions\Inventory\Common;
use App\Models\SubProduct;
use App\Models\SubProductPhoto;

class SubProductDetails
{
    public function run($sub_product_id)
    {
        $sub_product = $this->getSubProductByID($sub_product_id);
        $this->getFlashSale($sub_product);
        $this->getSubProductStock($sub_product);
        $this->getSubProductPhoto($sub_product);
        (new SubProductDiscount())->run($sub_product);
        $this->getProductVariation($sub_product);
        $this->getSubProductDetails($sub_product);
        UnsetData($sub_product, ['color', 'size', 'product_prices', 'product']);
        return $sub_product->only('id', 'flash_sale', 'price', 'stock_quantity', 'sub_color_id', 'sub_color', 'color_name', 'sub_size_id', 'sub_size', 'brand', 'photo', 'product_variation', 'name_translations', 'description_translations');
    }

    protected function getSubProductByID($sub_product_id)
    {
        $sub_product = SubProduct::with('product_prices')
            ->where('id', $sub_product_id)
            ->select('id', 'size_id', 'color_id', 'product_id')->first();
        if ($sub_product == null) responseStatus('Sub product is not found', 404);
        return $sub_product;
    }

    protected function getFlashSale($sub_product)
    {
        $flash_sale = collect($sub_product->flashSale)->first();
        $current_flash_sale = (new FlashSale())->currentFlashSale('sub_product');
        $flash_data = (new FlashSale())->flashSaleData($flash_sale, $current_flash_sale);
        $sub_product->flash_sale = $flash_data;
    }

    protected function getSubProductStock($sub_product)
    {
        $sub_product->stock_quantity = (new Common())->getsubProductQuantity($sub_product->id);
    }

    protected function getSubProductPhoto($sub_product)
    {
        $sub_product->photo = SubProductPhoto::where([['product_id', $sub_product->product_id],
            ['color_id', $sub_product->color_id]])->select('name', 'type')->get();
    }

    protected function getProductVariation($sub_product)
    {
        $sub_variations = $sub_product->product->thing->sub_variations;
        $sub_vars = [];
        foreach ($sub_variations as $sub_variation) {
            $variation = new \stdClass();
            $variation->variation = $sub_variation->variation->name_translations;
            $variation->sub_variation = $sub_variation->name_translations;
            $sub_vars[] = $variation;
        }
        $sub_product->product_variation = $sub_vars;
    }

    protected function getSubProductDetails($sub_product)
    {
        $sub_product->sub_color = $sub_product->color->icon;
        $sub_product->sub_color_id = $sub_product->color->id;
        $sub_product->color_name = $sub_product->color->name_translations[0]->name;
        $sub_product->sub_size = $sub_product->size->name;
        $sub_product->sub_size_id = $sub_product->size->id;
        $sub_product->price = $sub_product->product_prices->price;
        $sub_product->name_translations = $sub_product->product->name_translations;
        $sub_product->description_translations = $sub_product->product->description_translations;
    }

    protected function getBrand($sub_product)
    {
        $brands = $sub_product->product->thing->brands;
        foreach ($brands as $brand) {
            $sub_product->brand = $brand->name_translations;
        }
    }
}
