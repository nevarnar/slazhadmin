<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Filter\FilterInterface;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    private $filter;
    public function __construct(FilterInterface $filter){
        $this->filter = $filter;
    }

    public function getFilterData(Request $request){
        $data =  $this->filter->getFilterData($request);
        responseData('data',$data,200);
    }

    public function getFilteredSubProducts(Request $request){
        return $this->filter->getFilteredSubProducts($request);
    }

    public function getVariationsByCategoryId(Request $request){
        return $this->filter->getVariationsByCategoryId($request);
    }

}
