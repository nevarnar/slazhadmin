<?php

namespace App\Http\Repositories\Stock;

use App\Models\Stock;

interface StockRepositoryInterface
{
    public function list($request);
    
    public function createOrUpdate($request);

    public function getStockBySubProduct($request);

    public function editStock($request);

    public function getSubProductInStock($request);

    // public function details(Stock $stock);

    public function getSubProductBySeriesAndBrand($request); #not use after delete it

    public function getItemWithTypeInStock($request);
    
}
