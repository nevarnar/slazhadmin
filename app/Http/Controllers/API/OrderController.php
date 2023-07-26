<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Order\OrderInterface;

class OrderController extends Controller
{ 
    //
    protected $orderRepository;
    public function __construct(OrderInterface $repo)
    {
        $this->orderRepository=$repo;
    }
    public function store(Request $request){
        $order=$this->orderRepository->createOrUpdate($request);
        responseData('data',$order,200);
    }
   
}
