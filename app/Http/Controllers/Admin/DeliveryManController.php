<?php

namespace App\Http\Controllers\Admin;

use App\Models\Delivery;
use App\Models\DeliveryMan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Repositories\Delivery\DeliveryRepositoryInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Requests\API\DeliveryManRequest;

class DeliveryManController extends Controller
{
    //

    private $deliveryRepository;

    public function __construct(DeliveryRepositoryInterface $repo)
    {
        $this->deliveryRepository=$repo;
    }

    public function index(Request $request){
        $deliveries=$this->deliveryRepository->list($request);
        (new ResponsePaginatedApiData($deliveries, $request));
    }
    public function getDeliveryMen(Request $request){
        $deliveries=$this->deliveryRepository->list($request);
        responseData('data',$deliveries,200); 
    }
    public function createOrUpdate(DeliveryManRequest $request){
        (new UniqueCheck())->run($request,'delivery_man');
        $deliveries = $this->deliveryRepository->createOrUpdate($request);
        responseData('data', $deliveries, 200);
    }
    
    public function show($delivery_id){
        $dm = $this->deliveryRepository->getDetails($delivery_id);
        responseData('data', $dm, 200);
    }

    public function destroy($delivery_id){
        ($this->deliveryRepository->delete($delivery_id))? responseTrue('Deleted successfully '):responseFalse();
    }
  

    public function getDelivery(){
        $deliveries=$this->deliveryRepository->getDelivery();
        responseData('data',$deliveries,200); 
    }
    public function createDelivery(Request $request){
        Delivery::create([
            'name'=>$request->name,
        ]);
        return responseTrue('Delivery created successfully');
    }
}
