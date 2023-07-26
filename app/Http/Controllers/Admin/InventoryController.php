<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shelf;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Actions\Inventory\Common;
use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Requests\API\Inventory\InventoryRequest;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Repositories\Inventory\InventoryRepositoryInterface;

class InventoryController extends Controller
{
    //
    private $invRepository;

    public function __construct(InventoryRepositoryInterface $repo)
    {
        $this->invRepository=$repo;
    }

    public function index(Request $request){
        $inv=$this->invRepository->list($request);
        (new ResponsePaginatedApiData($inv, $request));
    }

    public function getInventory(Request $request){
        $inv=$this->invRepository->list($request);
        responseData('data', $inv, 200);
    }
    public function createOrUpdate(InventoryRequest $request){
        (new UniqueCheck())->run($request,'inventory');
        $inv = $this->invRepository->createOrUpdate($request);
        responseData('data', $inv, 200);
    }
    public function show(Inventory $inventory){
        $inv = $this->invRepository->details($inventory);
        responseData('data', $inv, 200);
    } 

    public function changeInventoryIsAvailable(Request $request){
        $model= Inventory::find($request->id);
        if ($model) {
            (new Common())->checkStockExistToDelete($model,'floor.shelf.inventory');
            \App\Models\Admin::setNullByInventoryId($request->id)->update([
                'inventory_id'=>null,
            ]);
            $model->is_available = $request->is_available;
            $model->save();
            responseStatus('Available update successfully', 200);
        }
        responseStatus("Available can't update for this product,Pls try again", 200);
    }

    public function destroy(Inventory $inventory){ 
        ($this->invRepository->delete($inventory))? responseTrue('Deleted successfully '):responseFalse();
    }

    public function destroyShelf(Shelf $shelf){
        ($this->invRepository->deleteShelf($shelf))? responseTrue('Deleted successfully '):responseFalse();
    }
}
