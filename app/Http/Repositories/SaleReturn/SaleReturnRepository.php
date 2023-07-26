<?php

namespace App\Http\Repositories\SaleReturn;

use App\Http\Actions\Inventory\Common;
use App\Http\Actions\Notification\SaveNotification;
use App\Http\Actions\Stock\StockModule;
use App\Models\Notification;
use App\Models\SaleReturn;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleReturnRepository implements SaleReturnInterface
{
    private $select = ['id', 'sub_product_id', 'qty', 'amount', 'reason_id', 'order_id', 'description', 'orderitemable_id', 'orderitemable_type', 'status', 'delivery_man_id', 'created_at', 'floor_id'];
    // public function list($request){
    //     $sale_returns=SaleReturn::with(['sale_return_photos','orderitemable','order'])->orderBy('id')
    //     ->get()->groupBy('order.order_id');
    //     foreach($sale_returns as $k=>$sale_return){
    //         $sale_return_obj[$k]=new stdClass();
    //         $sale_return_obj[$k]->order_id=$k;
    //         foreach($sale_return as $s){
    //             $s->product_name=$s->sub_product->product->name_translations[0] ? $s->sub_product->product->name_translations[0]->name :null;
    //             $s->color_name=$s->sub_product->color->name_translations[0]->name;
    //             $s->size_name=$s->sub_product->size->name;
    //             $s->reason_name=$s->reason->name;
    //             UnsetData($s,['sub_product_id','orderitemable_id','orderitemable_type','created_at','updated_at','reason_id','order_id','orderitemable','order','sub_product','reason']);
    //         }
    //         $sale_return_obj[$k]->sale_return=$sale_return;
    //     }
    //     return $sale_returns;
    // }
    // public function createSaleReturn($request){
    //     $data = $request->all();
    //     #test
    //     if (!isset($request->id)) {
    //         $data['id'] = null;
    //     }
    //     DB::beginTransaction();
    //     try {
    //         #sale return create
    //         $data['orderitemable_type'] = $request->type == 'sub_product'  ?  'order_item' : 'order_style_product';
    //         $data['orderitemable_id'] = $request->order_item_id;
    //         $sale_return = SaleReturn::updateOrCreate(
    //             ['id' => $data['id']],
    //             $data
    //         );
    //         if (isset($request->photo)) {
    //             $photos = MultipleUploadImage($request, 'photo');
    //             // if (isset($request->id)) {
    //             //     $old_photos=(new StylePhoto())->getStylePhoto($style->id,'gallery');
    //             //         DeleteOldPhoto($old_photos);
    //             //     (new StylePhoto())->deleteStylePhoto($style->id,'gallery');
    //             // }
    //             foreach ($photos as $photo) {
    //                 $sale_return->createSaleReturnPhoto([
    //                     'name' => $photo,
    //                 ]);
    //             }
    //         }
    //         DB::commit();
    //         return $sale_return;
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         responseStatus($e->getMessage(), 402);
    //         throw $e;
    //     }

    // }

    function list($request) {
        $sale_returns = SaleReturn::with(['sale_return_photos', 'reason', 'sale_return_product', 'delivery_man', 'floor'])
            ->latest()
            ->when(Auth::user()->hasPermission('order-management'), function ($query) {
                $query->whereIn('status', ['received', 'confirmed']);
            })
            ->when(Auth::user()->hasPermission('inventory-management'), function ($query) {
                $query->whereIn('status', ['confirmed', 'delivering', 'delivered']);
            })
            ->select($this->select)->get();
        foreach ($sale_returns as $sale_return) {
            $sale_return->order_id = $sale_return->order->order_id;
            $sale_return->product_name = $sale_return->sub_product->product->name_translations[0]->name;
            $sale_return->delivery_man = $sale_return->delivery_man;
            $sale_return->product_id = $sale_return->sub_product->product_id;
            if (!is_null($sale_return->floor_id) && Auth::user()->hasPermission('inventory-management')) {
                $sale_return->inventory = $sale_return->floor->shelf->inventory;
                $sale_return->available_floors = (new Common())->getAvailableFloorOfInventoryBySubProduct($sale_return->sub_product_id);
            }
            // dd($sale_return->sale_return_product->sub_product);
            if ($sale_return->sale_return_product) {
                $sale_return->sale_return_product->product_name = $sale_return->sale_return_product->sub_product->product->name_translations[0]->name;
                $sale_return->sale_return_product->size_name = $sale_return->sale_return_product->sub_product->size->name;
                $sale_return->sale_return_product->size = $sale_return->sale_return_product->sub_product->size;
                // dd($sale_return->sale_return_product->floor->shelf->inventory);
                $sale_return->sale_return_product->inventory = $sale_return->sale_return_product->floor->shelf->inventory;
                // $sale_return->sale_return_product->floor=$sale_return->sale_return_product->floor;
                $sale_return->sale_return_product->color = $sale_return->sale_return_product->sub_product->color->name_translations[0]->name;
                $sale_return->sale_return_product->floor_name = $sale_return->sale_return_product->floor->name;
                UnsetData($sale_return->sale_return_product, ['floor']);
                if (Auth::user()->hasPermission('inventory-management')) {
                    $sale_return->sale_return_product->available_floors = (new Common())->getAvailableFloorOfInventoryBySubProduct($sale_return->sale_return_product->sub_product->id);
                    $sale_return->sale_return_product->floor = $sale_return->sale_return_product->available_floors->where('id', $sale_return->sale_return_product->floor_id)->first();
                }
            }
            if (Auth::user()->hasPermission('order-management')) {
                $sale_return->inventories = $this->getAvailableFloorOfSubProductByInventory($sale_return->sub_product->id);
            }

            $sale_return->reasons = \App\Models\Reason::orderBy('id')->get();
            $sale_return->sub_product = $sale_return->sub_product;
            $sale_return->address = $sale_return->order->address->township;
            $sale_return->address->division_name = $sale_return->order->address->township->division->name_translations[0]->name;
            $sale_return->address->township_name = $sale_return->order->address->township->name_translations[0]->name;
            $sale_return->user = $sale_return->order->user->only(['id', 'name', 'phone_number']);
            UnsetData($sale_return->address, ['division', 'name_translations']);
            UnsetData($sale_return->sub_product, ['product', 'reason_id']);
            UnsetData($sale_return->sale_return_product, ['sub_product']);

        }
        return $sale_returns;

    }

    public function getAvailableFloorOfSubProductByInventory($sub_product_id)
    {
        $inventories = (new Common())->getInventories();
        foreach ($inventories as $inventory) {
            $inventory->available_floors = (new Common())->getAvailableFloorBySubProductOfInventory($sub_product_id, $inventory->id);
        }
        return $inventories;
    }

    public function updateSaleReturnAction($request)
    {
        DB::beginTransaction();
        try {
            $sale_return = SaleReturn::findOrfail($request->sale_return_id);
            if ($request->status === 'confirmed') {
                $sale_return->floor_id = $request->item['floor_id'];
                $sale_return->reason_id = $request->reason_id;
                $sale_return_product_id = null;
            } elseif ($request->status === 'delivering') {
                $sale_return->floor_id = $request->item['floor_id'];
                $sale_return->delivery_man_id = $request->delivery_man_id;
                $sale_return_product_id = $sale_return->sale_return_product->id;
            }
            $sale_return->status = $request->status;
            $sale_return->save();
            if ($sale_return && ($request->status === 'confirmed' || $request->status === 'delivering')) {
                if ($sale_return->reason_id == 2) {
                    $sale_return_product = $sale_return->saveSaleReturnProduct([
                        'sub_product_id' => $request->return_item['id'],
                        'floor_id' => $request->return_item['floor_id'],
                    ], $sale_return_product_id);
                    if ($request->status === 'confirmed') {
                        $sale_return_product ? (new StockModule())->actionStock($request->item['id'], $request->item['floor_id'], $request->item['quantity'], 'add') : responseStatus("SaleReturn isn't defined", 401);
                        $sale_return_product ? (new StockModule())->actionStock($request->return_item['id'], $request->return_item['floor_id'], $request->return_item['quantity'], 'subtract') : responseStatus("SaleReturn isn't defined", 401);
                    } elseif ($request->status === 'delivering') {
                        #change floor for subproduct floor
                        if ($sale_return->floor_id != (int) $request->item['id']) {

                            $sale_return_product ? (new StockModule())->actionStock($sale_return->sub_product_id, $sale_return->floor_id, $sale_return->qty, 'subtract') : responseStatus("SaleReturn isn't defined", 401);

                            $sale_return_product ? (new StockModule())->actionStock($request->item['id'], $request->item['floor_id'], $request->item['quantity'], 'add') : responseStatus("SaleReturn isn't defined", 401);

                            // $sale_return_product ? (new StockModule())->actionStock($request->return_item['id'],$request->return_item['floor_id'],$request->return_item['quantity'],'add') : responseStatus("SaleReturn isn't defined",401);
                        }

                        #endregion

                        #change floor for new subproduct
                        if ($sale_return->sale_return_product->floor_id != (int) $request->return_item['id']) {

                            $sale_return_product ? (new StockModule())->actionStock($sale_return->sale_return_product->sub_product_id, $sale_return->sale_return_product->floor_id, $request->return_item['quantity'], 'subtract') : responseStatus("SaleReturn isn't defined", 401);

                            $sale_return_product ? (new StockModule())->actionStock($request->return_item['id'], $request->return_item['floor_id'], $request->return_item['quantity'], 'add') : responseStatus("SaleReturn isn't defined", 401);

                        }

                        #end

                    }

                } elseif ($sale_return->reason_id == 1) {
                    $sale_return ? (new StockModule())->actionStock($request->item['id'], $request->item['floor_id'], $request->item['quantity'], 'subtract') : responseStatus("SaleReturn isn't defined", 401);
                }
            }

            if ($sale_return) {
                $notify = (new SaveNotification())->saveNotify($sale_return, 'Sale return have been ' . $sale_return->status, 'sale_return');
                if ($notify) {
                    $notification = (new SaveNotification())->save($notify, Auth::user(), 'admin');
                    $url = 'http://127.0.0.1:8000';
                    $data = [
                        'id' => $notification->id,
                        'notification_count' => Notification::notificationIsRead(0)->countNotiForUser(),
                        'type' => $notification->notify->notifiable_type,
                        'order_id' => $sale_return->order_id,
                        'status' => $sale_return->status,
                        'date' => $sale_return->updated_at,
                    ];
                    $user = User::findOrfail($sale_return->order->user_id);
                    $notification->toMultipleDevice($user, 'Sale Return Notification ', 'Your return product have been ' . $sale_return->status, null, $url, $data);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }

    }
}
