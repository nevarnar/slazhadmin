<?php

namespace App\Http\Controllers\API;

use App\Models\Discount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Discount\DiscountInterface;

class DiscountController extends Controller
{
    //
    private $discountRepository;

    public function __construct(DiscountInterface $repo)
    {
        $this->discountRepository=$repo;
    }

    public function getDiscountByProduct($sub_product_id){
        $discount=$this->discountRepository->getDiscountByProduct($sub_product_id);
        responseData('data',$discount,200);
    }

    public function getFlashSales(Request $request){
         $flash_sales = $this->discountRepository->getFlashSaleItems($request->gender_id);
         responseData('flash_sales',$flash_sales,200);
    }

    public function getFlashSalesStyle(Request $request)
    {
        $flash_styles = $this->discountRepository->getFlashSaleStyles($request->gender_id);
        responseData('style_flash_sales',$flash_styles,200);
    }
}
