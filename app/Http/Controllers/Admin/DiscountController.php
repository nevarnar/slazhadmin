<?php

namespace App\Http\Controllers\Admin;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Models\DiscountSubProduct;
use App\Http\Controllers\Controller;
use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Repositories\Discount\DiscountInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Requests\API\Discount\DiscountCreateRequest;

class DiscountController extends Controller
{
    //
    private $discountRepository;

    public function __construct(DiscountInterface $repo)
    {
        $this->discountRepository=$repo;
    }

    public function index(Request $request){
        $discount_items=$this->discountRepository->list($request);
        (new ResponsePaginatedApiData($discount_items, $request));
    }

    public function show(Discount $discount){
        $discount_item=$this->discountRepository->details($discount);
        responseData('data',$discount_item,200);
    }

    public function createOrUpdate(Request $request){
        $created_discount_item=$this->discountRepository->createOrUpdate($request);
        responseData('data',$created_discount_item,200);
    }

    public function destroy(Discount $discount){
        ($this->discountRepository->delete($discount)) ?
         responseTrue('Discount Delete Successfully ') : responseFalse();
    }

    public function getDiscountType(){
        $discount_type=$this->discountRepository->getDiscountType();
        responseData('data',$discount_type,200);
    }

    public function validateSubProduct(Request $request){
        $created_discount_item=$this->discountRepository->validateDiscountSubProduct($request);
        responseData('data',$created_discount_item,200);
        
    }

    #new discount 
   
    
}
