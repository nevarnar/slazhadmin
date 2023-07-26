<?php

namespace App\Http\Controllers\Admin;

use App\Models\FlashSale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\FlashSale\FlashSaleInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

class FlashSaleController extends Controller
{
    //
    private $flashSaleRepository;

    public function __construct(FlashSaleInterface $repo)
    {
        $this->flashSaleRepository=$repo;
    }

    public function index(Request $request){
        $flash_sale=$this->flashSaleRepository->list($request);
        (new ResponsePaginatedApiData($flash_sale, $request));
    }
    
    public function show(FlashSale $flash_sale){
        $flash_sale_item=$this->flashSaleRepository->details($flash_sale);
        responseData('data',$flash_sale_item,200);
    }

    public function createOrUpdate(Request $request){
        $created_flash_sale_item=$this->flashSaleRepository->createOrUpdate($request);
        responseData('data',$created_flash_sale_item,200);
    }

    public function destroy(FlashSale $flash_sale){
        ($this->flashSaleRepository->delete($flash_sale)) ?
         responseTrue('flash_sale Delete Successfully ') : responseFalse();
    }

    public function validateSubProduct(Request $request){
        $this->flashSaleRepository->validateSubProductForFlashSale($request);
        responseTrue('Add successfully');
        // responseData('data',$flash_sale,200);
        
    }
    public function deleteItem(Request $request){
        $this->flashSaleRepository->deleteItem($request);
        responseTrue('Delete successfully');
    }
    public function changeFlashSaleIsAvailable(Request $request){
        $flash_sale= FlashSale::find($request->id);
        if ($flash_sale) {
            $flash_sale->is_available = $request->is_available;
            $flash_sale->save();
            responseStatus('Available update successfully', 200);
        }
        responseStatus("Available can't update for this flash sale,Pls try again", 403);
    }
    
}
