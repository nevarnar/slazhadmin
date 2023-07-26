<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\SubProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Repositories\SubProduct\SubProductRepositoryInterface;

class SubProductController extends Controller
{
    private SubProductRepositoryInterface $subProductRepository;
    
    public function __construct(SubProductRepositoryInterface $repo)
    {
         $this->subProductRepository=$repo;
    }
    
    public function getAllSubProducts(Request $request){
        $sub_products= $this->subProductRepository->list($request);
        (new ResponsePaginatedApiData($sub_products, $request));
    }
   
    public function changeSubProductIsAvailable(Request $request){
        $sub_product= SubProduct::find($request->id);
        if ($sub_product) {
            $sub_product->is_available = $request->is_available;
            $sub_product->save();
            responseStatus('Available update successfully', 200);
        }
        responseStatus("Available can't update for this product,Pls try again", 200);
    }

    public function getAvailableColorByProduct($product_id){
        $colors=$this->subProductRepository->getAvailableColorByProduct($product_id);
        responseData('data',$colors, 200);
    }
    public function searchSubPorductList(Request $request){
        $sub_products=$this->subProductRepository->searchSubProduct($request);
        responseData('data',$sub_products, 200);

    }
}
