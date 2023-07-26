<?php

namespace App\Http\Repositories\Product;

use App\Models\Product;

interface ProductRepositoryInterface{

    public function list($request);

    public function listWhenIsAvailableTrue();

    public function createOrUpdate($request);

    // public function delete(Product $product);

    public function details(Product $product);

    public function getSubProductByProduct($product);

    public function availableSizeByProductAndColor($product_id,$color_id);

    public function getProductBySubCategory($sub_product_id);

    public function deletePhoto($request);

    public function getProductDetail($product_id);

    public function getSubProductDetail($sub_product_id);

    public function setProductData($products);

    public function getProductBySeriesAndBrand($request);

}
