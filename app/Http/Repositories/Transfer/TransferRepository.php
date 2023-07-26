<?php

namespace App\Http\Repositories\Transfer;

use App\Http\Actions\Inventory\Common;
use App\Models\Transfer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Actions\Stock\StockModule;

class TransferRepository implements TransferInterface
{
    private $select_data = ['id', 'transfer_id', 'from_inventory_id', 'to_inventory_id', 'send_date', 'arrive_date', 'status'];
    public function query()
    {
        return Transfer::with(['from_inventory', 'to_inventory'])
        ->orderBy('created_at', 'desc')->select($this->select_data);
    }
    function list($request) {
        $query = $this->query();
        if ($request->status != null || $request->status != "") {
            $query->where('status', $request->status);
        }
        if (Auth::user()->isSuperAdmin()) {
            if ($request->inventory_id != null || $request->inventory_id != "") {
                $query->where('from_inventory_id', $request->inventory_id)    
                        ->orWhere('to_inventory_id', $request->inventory_id);
            }
        }else if (Auth::user()->hasPermission('inventory-management')) {
            $query->where('to_inventory_id', Auth::user()->inventory_id)
            ->orWhere('from_inventory_id', Auth::user()->inventory_id)
            ->where('status', $request->status);
        }

        return $query->get();
    }

    public function create($request)
    {
        $json_data = JsonDecode($request->stocks);
        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['send_date'] = now();
            $data['from_inventory_id'] = Auth::user()->inventory_id;
            // $data['transfer_id']=Str::random(7);
            $transfer = Transfer::create($data);
            if ($transfer) {
                (new StockModule())->storeTransfer($transfer->id, $json_data);
            }
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
    }

    public function createAcceptTransfer($request){
        DB::beginTransaction();
        try {
            $json_data = JsonDecode($request->stocks);
            $transfer = Transfer::findOrfail($request->transfer_id);
            $transfer->arrive_date=now();
            $transfer->status = 'confirm';
            $transfer->save();
            $sub_product_transfer = DB::table('sub_product_transfer')->where('transfer_id',$request->transfer_id)->get();
            (new StockModule())->storeTransfer($request->transfer_id, $json_data);
            if ($sub_product_transfer->isNotEmpty()) {
                foreach ($sub_product_transfer as $sub_transfer) {
                    (new StockModule())->actionStocks($sub_transfer, 'subtract');
                }
            }
            foreach($json_data as $d){
                (new StockModule())->actionStocks($d,'add');
            }
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
    }

    public function detail($transfer)
    {
        $groups = collect($transfer->sub_products)->groupBy('id');
        $sub_products = [];
        foreach ($groups as $group) {
            $to_floor_arr=[];
            $from_floor_arr=[];
            $qty=0;
            foreach ($group as $g) {
                #test received floors
                #From inventory transfer floors
                if($this->getFloorArr($transfer->from_inventory_id,$g)!=null){
                    $from_floor_arr[]=$this->getFloorArr($transfer->from_inventory_id,$g);
                }
                #end

                #to inventory transfer floors
                if($this->getFloorArr($transfer->to_inventory_id,$g)!=null){
                    $to_floor_arr[]=$this->getFloorArr($transfer->to_inventory_id,$g);
                }
                // $floor_ids_for_to_inventory=$this->getFloorIdArray($transfer->to_inventory_id);
                // if(count($floor_ids_for_to_inventory)>0){
                //     if(in_array($g->pivot->floor->id,$floor_ids_for_to_inventory)){
                //         $to_floor = $g->pivot->floor;
                //         $to_floor->quantity = $g->pivot->quantity;
                //         $to_floor_arr[] = $to_floor;
                //     }
                // }
                #end
                $qty+=$g->pivot->quantity;
                $g->product->brands = $g->product->thing->brands[0];
                $g->product->sub_categories = $g->product->thing->sub_categories[0];
                UnsetData($g->product, ['thing']);
            }
            $unique_sub_product = $group->unique();
            #transfer from these floors
            $unique_sub_product[0]->floor = $from_floor_arr;
            #accept transfers to these floors 
            $unique_sub_product[0]->to_floor = $to_floor_arr;
            #end
            $unique_sub_product[0]->total_quantity = array_sum(array_column($from_floor_arr,'quantity'));

            UnsetData($unique_sub_product[0], ['pivot']);
            $sub_products[] = $unique_sub_product[0];
        }
        UnsetData($transfer, ['sub_products']);

        if(Route::currentRouteName()=='accept_inventory'){
          $this->getRecommendFloorBySubProduct($sub_products);
        }
        $transfer->sub_products = $sub_products;
        $transfer->from_inventory=$transfer->from_inventory;
        $transfer->to_inventory=$transfer->to_inventory;
        return $transfer;
    }

    public function delete($transfer)
    {
        return $transfer->delete();
    }


    protected function getRecommendFloorBySubProduct($sub_products)
    {
        foreach ($sub_products as $sub) {
            // $shelves = \App\Models\Shelf::where('inventory_id', Auth::user()->inventory_id)->get();
            $shelves = \App\Models\Shelf::getByInventory(Auth::user()->inventory_id)->get();
            if ($shelves->isNotEmpty()) {
                $recommended_floors= [];
                $available_floors = [];
                foreach ($shelves as $shelf) {
                    foreach ($shelf->floors as $f) {
                        $query=\App\Models\FloorSubProduct::getSubProductInFloor($sub->id,$f->id)->first();
                        if($query){
                            array_push($recommended_floors, $f);
                        }
                        array_push($available_floors,$f);
                    }
                }
                if(count($recommended_floors)>0){
                    count($recommended_floors)>3 ? $sub->recommended_floor=array_slice($recommended_floors,0,3) :$sub->recommended_floor=$recommended_floors;
                }else{
                    count($available_floors) >3 ? $sub->recommended_floor=array_slice($available_floors,0,3) :$sub->recommended_floor=$available_floors;
                }
            }
        }
        return $sub_products;
    }


    public function getFloorIdArray($id){
        $floors=(new Common())->floorByInventory($id);
        $data=collect($floors)->map(function($a){
           return $a->id;
        });
        return $data->toArray();
   }

   public function getFloorArr($inv_id,$g){
       $floor_ids_in_inventory=$this->getFloorIdArray($inv_id);
       if(count($floor_ids_in_inventory)>0){
           if(in_array($g->pivot->floor->id,$floor_ids_in_inventory)){
               $floor = $g->pivot->floor;
               $floor->quantity = $g->pivot->quantity;
               return $floor;
           }
       }
   }

}
