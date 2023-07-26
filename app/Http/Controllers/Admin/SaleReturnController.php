<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\SaleReturn\SaleReturnInterface;
use Illuminate\Http\Request;

class SaleReturnController extends Controller
{
    //

    private $saleReturnRepository;

    public function __construct(SaleReturnInterface $repo)
    {
        $this->saleReturnRepository=$repo;
    }

    public function index(Request $request){
        $sale_returns=$this->saleReturnRepository->list($request);
        responseData('data',$sale_returns,200);
    }

    public function updateSaleReturnAction(Request $request){
        $sale_return=$this->saleReturnRepository->updateSaleReturnAction($request);
        responseData('data',$sale_return,200);

    }

}
