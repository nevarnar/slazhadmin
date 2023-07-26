<?php

namespace App\Http\Controllers\API;

use App\Http\Actions\Inventory\Common;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $repo)
    {
        $this->productRepository = $repo;
    }

    public function getProductDetails(Request $request)
    {
        $product =  $this->productRepository->getProductDetail($request->product_id);
        responseData('product', $product, 200);
    }

    public function getSubProductDetails(Request $request)
    {
        $sub_product =  $this->productRepository->getSubProductDetail($request->sub_product_id);
        responseData('sub_product', $sub_product, 200);
    }

    public function getTotalSubProductQuantity(Request $request){
        $qty=(new Common())->getsubProductQuantity($request->sub_product_id);
        responseData('quantity', $qty, 200);
    }

}
