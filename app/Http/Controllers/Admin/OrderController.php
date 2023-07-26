<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Order\OrderInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

class OrderController extends Controller
{
    //
    protected $orderRepository;
    public function __construct(OrderInterface $repo)
    {
        $this->orderRepository=$repo;
    }

    public function index(Request $request){
        $orders=$this->orderRepository->list($request);
        (new ResponsePaginatedApiData($orders, $request));
    }

   

    public function ordersByInventory(Request $request){
        $orders=$this->orderRepository->orderListByInventory($request);
        (new ResponsePaginatedApiData($orders, $request));
    }

    public function actionStatus(Request $request){
        $order=$this->orderRepository->actionStatus($request);
        responseData('data',$order,200);
    }


    public function deleteOrderItem($order_item_id){
    $this->orderRepository->deleteOrderItem($order_item_id) ?
    responseTrue('Order Delete Successfully ') : responseFalse();
    }
    
    public function saveDeliveryMan(Request $request){
        $order=$this->orderRepository->saveDeliveryMan($request);
        responseData('data',$order,200);
    }

    public function actionStatusInventoryOrder(Request $request){
        $order=$this->orderRepository->actionStatusInventoryOrder($request);
        // $order=Order::find($request->id);
        // if($order){
        //     $order->status=$request->status;
        //     $order->save();
        //     responseStatus('Delivering is successfully',200);
        // }
        // responseStatus('Data not found',404);
    }


    public function getToken(Request $request){
        dd($request->all());
    }


    
}
