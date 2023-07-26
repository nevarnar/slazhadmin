<?php

namespace App\Http\Repositories\Order;

use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Discount;
use App\Models\FlashSale;
use App\Models\OrderItem;
use App\Models\Notification;
use App\Models\FloorSubProduct;
use App\Models\OrderStyleProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Actions\Inventory\Common;
use App\Http\Actions\Coupon\CouponCalculation;
use App\Http\Actions\Notification\SaveNotification;
use stdClass;

class OrderRepository implements OrderInterface
{

    function list($request) {
        $orders = Order::with(['address.township.division', 'user', 'order_items','inventory','delivery_man'])
        // ->where('id',140)
            ->whereHas('order_items', function ($q) {
                $q->whereNotNull('id');
            });
            if (Auth::user()->hasPermission('inventory-management')) {
                $orders->orderBy('updated_at','desc')
                ->when($request->status, function ($query) use ($request) {
                    $query->where('status', $request->status);
                })
                ->whereIn('status',['confirmed','delivering','delivered'])
                 ->whereHas('order_items', function ($q) {
                        $q->whereHas('floor.shelf.inventory', function ($qa) {
                            $qa->where('id', Auth::user()->inventory_id);
                        })
                            ->orWhereHas('order_style_products', function ($qb) {
                                $qb->whereHas('floor.shelf.inventory', function ($qd) {
                                    $qd->where('id', Auth::user()->inventory_id);
                                });
                            });
                    });
                // $orders->whereHas('order_item.order_style_product',function($qb){
                //     $qb->whereHas('floor.shelf.inventory',function($qd){
                //         $qd->where('id',Auth::user()->inventory_id);
                //     });
                // });
            }else if(Auth::user()->hasPermission('order-management')){
                $orders->whereIn('status', ['confirmed', 'received']);
            }
            else if (Auth::user()->isSuperAdmin()) {
                $orders->whereIn('status', ['confirmed', 'received', 'delivering']);
            }
        $orders=$orders->orderBy('id','desc')->get();
        return $this->addFloor($orders);
    }

    public function addFloor($orders)
    {
        foreach ($orders as $order) {
            $order_item_array=[];
            foreach ($order->order_items as $k=>$oi) {
                if ($oi->orderable_type == 'sub_product') {
                    (new Common())->setSubProductPhoto($oi->orderable); #match sub product photo with sub product id
                    $orderItemObj=new stdClass(); 
                    $orderItemObj->item_id=$oi->id;
                    $orderItemObj->type=$oi->orderable_type;
                    $orderItemObj->sub_product_id=$oi->orderable_id;
                    $order_item_array[]=$orderItemObj;
                    if(!is_null($oi->floor_id) ){
                        $fs=FloorSubProduct::where('floor_id',$oi->floor_id)->where('sub_product_id',$oi->orderable_id)->first();
                        if($fs && $oi->floor){
                            $oi->floor->qty=$fs->quantity-$fs->order_quantity;
                        }else{
                            $oi->qty=0;
                        }
                        #temp comment
                        // $order->available_floors = (new Common())->getAvailableFloorBySubProductOfInventory($oi->orderable_id,$order->inventory_id);

                        // $inventories->available_floors=(new Common())->getAvailableFloorOfInventoryBySubProduct($oi->orderable_id);
                    }
                }

                if ($oi->orderable_type == 'style') {
                    foreach ($oi->order_style_products as $osp) {
                        $orderItemObj=new stdClass(); 
                        $orderItemObj->item_id=$osp->id;
                        $orderItemObj->type=$oi->orderable_type;
                        $orderItemObj->sub_product_id=$osp->sub_product_id;
                        $order_item_array[]=$orderItemObj;
                        (new Common())->setSubProductPhoto($osp->sub_product); #match sub product photo with sub product id
                        if(!is_null($osp->floor_id) ){
                            $fs=FloorSubProduct::where('floor_id',$osp->floor_id)->where('sub_product_id',$osp->sub_product_id)->first();
                            if($fs && $osp->floor){
                                $osp->floor->qty=$fs->quantity-$fs->order_quantity;
                            }else{
                                $osp->floor->qty=0;
                            }
                            #temp comment
                            // $osp->available_floors = (new Common())->getAvailableFloorBySubProductOfInventory($osp->sub_product_id,$order->inventory_id);
                        }
                        // $available_floors = (new Common())->getAvailableFloorOfInventoryBySubProduct($osp->sub_product_id);
                    }
                }
            }
            // if(is_null($order->inventory)){
                $order->inventories=(new Common())->getInventoryByAvailableFloorOfSubProduct($order_item_array);
            // }
        }
        return $orders;
    }

    public function orderListByInventory($request)
    {
        $orders = Order::with(['address.township.division', 'user', 'order_items', 'delivery_man'])
            ->orderBy('id', 'desc')
            ->whereHas('order_items', function ($q) {
                $q->whereNotNull('id');
            });
        if (Auth::user()->hasPermission('inventory-management')) {
            $orders->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->whereIn('status',['confirmed','delivering','delivered'])
             ->whereHas('order_items', function ($q) {
                    $q->whereHas('floor.shelf.inventory', function ($qa) {
                        $qa->where('id', Auth::user()->inventory_id);
                    })
                        ->orWhereHas('order_style_products', function ($qb) {
                            $qb->whereHas('floor.shelf.inventory', function ($qd) {
                                $qd->where('id', Auth::user()->inventory_id);
                            });
                        });
                });
            // $orders->whereHas('order_item.order_style_product',function($qb){
            //     $qb->whereHas('floor.shelf.inventory',function($qd){
            //         $qd->where('id',Auth::user()->inventory_id);
            //     });
            // });
        } else if (Auth::user()->isSuperAdmin()) {
            $orders->whereIn('status', ['confirmed', 'received', 'delivering']);
        }

        $orders = $orders->orderBy('id')->get();
        return $this->addFloor($orders);
        // foreach ($orders as $order) {
        //     foreach ($order->sub_product_orders as $sub_order) {
        //         $available_floors = (new Common())->getAvailableFloorOfInventoryBySubProduct($sub_order->sub_product_id);
        //         $sub_order->available_floors = $available_floors;
        //     }
        // }
        // return $orders;
    }

    public function createOrUpdate($request)
    {
        $order_items = json_decode($request->items);
        $data = $request->all();
        DB::beginTransaction();
        try {
            if (!isset($request->id)) {
                $data['id'] = null;
            }
            $id = Order::max('id');
            $no = $id == null ? 0 : $id;
            $order_id = now()->format('h:iAdMY') . '-' . str_pad($no, 7, "0", STR_PAD_LEFT) . '-' . UserData()->id;
            $order = Order::create([
                'order_id' => $order_id,
                'date' => now(),
                'user_id' => UserData()->id,
                'total_original_price' => $request->total_original_price,
                'total_discount_value' => $request->total_discount_value,
                'total_quantity' => $request->total_quantity,
                'total_value' => $request->total_value,
                'is_delivery_free' => $request->is_delivery_free === 'true' ? 1 : 0,
                'tax' => $request->tax,
                'delivery_fee' => $request->delivery_fee,
                'status' => 'received',
                'address_id' => $request->address_id,
                'payment_type_id' => 1,
            ]);
            if ($order) {
                foreach ($order_items as $oi) {
                    $order_item_id = OrderItem::create([
                        'order_id' => $order->id,
                        'original_price' => $oi->original_price,
                        'total_value' => $oi->total_value,
                        'buying_quantity' => $oi->buying_quantity,
                        'is_delivery_free' => $oi->is_delivery_free === 'true' ? 1 : 0,
                        'flash_sale_id' => $oi->discount != null ? (isset($oi->discount->flash_sale_id) ? $oi->discount->flash_sale_id : null) : null,
                        'discount_id' => $oi->discount != null ? (isset($oi->discount->id) ? $oi->discount->id : null) : null,
                        'orderable_type' => $oi->type == 'product' ? 'sub_product' : 'style',
                        'orderable_id' => $oi->id,
                    ]);
                    if ($oi->type == 'style' && $order_item_id) {
                        foreach ($oi->style_products as $sp) {
                            OrderStyleProduct::create([
                                'order_item_id' => $order_item_id->id,
                                'original_price' => $sp->original_price,
                                'total_value' => $sp->total_value,
                                'buying_quantity' => $sp->buying_quantity,
                                'is_delivery_free' => $sp->is_delivery_free === 'true' ? 1 : 0,
                                'flash_sale_id' => $sp->discount != null ? (isset($sp->discount->flash_sale_id) ? $sp->discount->flash_sale_id : null) : null,
                                'discount_id' => $sp->discount != null ? (isset($sp->discount->id) ? $sp->discount->id : null) : null,
                                'sub_product_id' => $sp->id,
                            ]);
                        }
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }

        return $order;
    }
    public function actionStatus($request)
    {

        #status=> received,confirmed,cancelled
        if($request->status=='delivering' ){
            $this->actionStatusInventoryOrder($request);
        }elseif($request->status=='delivered'){
            $order = Order::find($request->order_id);
            $order->status='delivered';
            $order->save();
        }
        else{
            $total_org_price = 0;
            $total_discount_value = 0;
            $total_buying_quantity = 0;
            DB::beginTransaction();
            try {
                $order = Order::find($request->order_id);
                $cal_total_value=(new CouponCalculation())->calTotalOriginalValue($request->items);
                $coupon_discount_value=0;
                $discount_value=0;
                foreach ($request->items as $i) {   
                    if ($i['type'] == 'sub_product') {
                        $order_item = OrderItem::find($i['id']);
                        if($order_item->orderable->product){
                            $product=$order_item->orderable->product;
                            $product->purchase_count+=1;
                            $product->save();
                        }
                        if ($order_item) {
                            $discount_value = $this->getDiscountValue($order_item) * $i['quantity'];
                            $order_item->buying_quantity = $i['quantity'];
                            $order_item->floor_id = $i['floor_id'];
                            #coupon calculation 
                            if(!is_null($order_item->coupon_id)){ 
                                if((new CouponCalculation())->calCouponDiscount($order_item->coupon,$order_item,$cal_total_value)){
                                    $coupon_discount_value=$order_item->coupon->discount_value;
                                }else{
                                    $order->coupon_id=null;
                                }
                            }
                           
                            #end coupon region
                            $order_item->total_value = ($order_item->original_price* $i['quantity'])  - ($discount_value + $coupon_discount_value);
                            $order_item->save();
                            // dd($order_item->total_value);
                            $this->addOrderQuantityToFloor($order_item, $order_item->orderable_id);
                        }
                    } else {
                        $sub_total_discount_value = 0;
                        $style_org_price = 0;
                        foreach ($i['order_style_products'] as $order_style_sub) {
                            $o_sub = OrderStyleProduct::find($order_style_sub['id']);
                            if ($o_sub) {
                                $discount_value = $this->getDiscountValue($o_sub) * $order_style_sub['quantity'];
                                $sub_total_discount_value += $discount_value;
                                $o_sub->buying_quantity = $i['quantity'];
                                $o_sub->floor_id = $order_style_sub['floor_id'];
                                $o_sub->total_value = ($o_sub->original_price - $discount_value) * $i['quantity'];
                                $style_org_price += $o_sub->original_price;
                                $o_sub->save();
                                $this->addOrderQuantityToFloor($o_sub, $o_sub->sub_product_id);
                            }
                        }
                        $order_item = OrderItem::find($i['id']);
                        if ($order_item) {
                            $discount_value = $this->getDiscountValue($order_item); //get Discount Amount of sub product or style
                            $total_discount_of_style = $discount_value + $sub_total_discount_value;
                            $order_item->original_price = $style_org_price;
                            $order_item->buying_quantity = $i['quantity'];
                            if(!is_null($order_item->coupon_id)){
                                if((new CouponCalculation())->calCouponDiscount($order_item->coupon,$order_item,$cal_total_value)){
                                    $coupon_discount_value=$order_item->coupon->discount_value;
                                }else{
                                    $order_item->coupon_id=null;
                                }
                            }
                            $total_value = (($order_item->original_price - $total_discount_of_style - $coupon_discount_value) * $i['quantity']);
                            $order_item->total_value = $total_value ;
                            $order_item->save();
                        }
                    }

                    #total
                    $total_org_price += ($order_item->original_price * $i['quantity']);
                    $dis_value = $i['type'] == 'style' ? ($total_discount_of_style * $i['quantity'])  : $discount_value ;
                    $total_discount_value += $dis_value + $coupon_discount_value;
                    $total_buying_quantity += $i['quantity'];
                }
                // dd($total_org_price);
                $order->coupon_discount_value=!is_null($order->coupon_id) ? $order->coupon->discount_value : $coupon_discount_value;
                $order->total_quantity = $total_buying_quantity;
                $order->status = $request->status;
                $order->total_original_price = $total_org_price;
                $order->total_discount_value = $total_discount_value;
                $order->inventory_id=$request->inventory_id;
                $order->tax = 0;
                // if ($coupon) {
                //     $coupon->coupon_discount_type == 'free_delivery' ? $order->is_delivery_free = 1 : 0;
                // }
                $delivery_fee = $order->is_delivery_free == 1 ? 0 : $order->delivery_fee;
                $order->delivery_fee=$delivery_fee;
                // $order->total_value = ($total_org_price - ($total_discount_value+$coupon_discount_value)) + $delivery_fee;
                $order->save();
                #notification
                $notify = (new SaveNotification())->saveNotify($order, 'You received order '. $request->status, 'order');
                if ($notify) {
                    $notification = (new SaveNotification())->save($notify, Auth::user(), 'admin');
                    $url = 'http://127.0.0.1:8000';
                    $data = [
                        'id' => $notification->id,
                        'notification_count' => Notification::notificationIsRead(0)->countNotiForUser(),
                        'type' => $notification->notify->notifiable_type,
                        'order_id' => $order->order_id,
                        'order_status' => $order->status,
                        'order_date' => $order->updated_at,
                    ];
                    $user = User::findOrfail($order->user_id);
                    $notification->toMultipleDevice($user, 'Order ' . $order->status, 'Order ' . $order->status, null, $url, $data);
                }
                #end notification
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                responseStatus($e->getMessage(), 402);
                throw $e;
            }
            return $order;
        }
        
    }

    public function addOrderQuantityToFloor($item, $sub_id)
    {

        $floor_sub_product = (new Common())->getFloorSubProduct($item->floor_id, $sub_id);
        $floor_sub_product->update([
            'order_quantity' => $floor_sub_product->order_quantity + $item->buying_quantity,
        ]);
    }

    public function getDiscountValue($order_item)
    {
        $discount_value = 0;
        if ($order_item->flash_sale_id != null) {
            $flash_sale = FlashSale::whereId($order_item->flash_sale_id)->first();
            if ($flash_sale) {
                if ($flash_sale->flashsaleable_type == 'style') {
                    $discount_value = $flash_sale->flash_sale_styles->where('style_id', $order_item->orderable_id)->sum('discount_value');
                } else {
                    // dd($flash_sale->flash_sale_sub_products);
                    $discount_value = $flash_sale->flash_sale_sub_products->where('sub_product_id', $order_item->orderable_id)->sum('discount_value');
                }
            } else {
                responseStatus('Flashsale not found ', 404);
            }
            // if($f_sub->flash_sale->min_buying_amount!=null){
            //     if($order_item->original_price*$i['quantity'] >=$f_sub->min_buying_amount){
            //         $discount_value=$f_sub->discount_value;
            //     }
            //     $discount_value=0;
            // }else if($f_sub->max_buying_count!=null){
            //     if($i['quantity'] <= $f_sub->max_buying_count){
            //         $discount_value=$f_sub->discount_value;
            //     }
            //     $discount_value=0;
            // }
            // else{
            //     $discount_value=$f_sub->discount_value;
            // }

        } else if ($order_item->discount_id != null) {
            $sub_discount = Discount::whereId($order_item->discount_id)->first();
            // dd($sub_discount->discount_value);
            if ($sub_discount) {
                $discount_value = $sub_discount->discount_value;
            }
        }
        // dd('Discount ',$discount_value);
        return $discount_value;
    }

    public function calOrderAmount($request)
    {
        $total_org_price = 0;
        $total_discount_value = 0;
        $total_buying_quantity = 0;
        foreach ($request->items as $i) {

            if ($i['type'] == 'sub_product') {
                $order_item = OrderItem::find($i['id']);
                if ($order_item) {
                    $discount_value = $this->getDiscountValue($order_item);
                    $order_item->buying_quantity = $i['quantity'];
                    $order_item->floor_id = $i['floor_id'];

                    $total_value = ($order_item->original_price * $i['quantity']) - $discount_value;
                    #coupon_region

                    if ($order_item->coupon_id != null) {
                        $coupon = Coupon::find($order_item->coupon_id);
                        if ($coupon->coupon_discount_type->name == 'fixed_amount') {
                            $coupon_discount_value = $coupon->discount_value;
                        } elseif ($coupon->coupon_discount_type->name == 'percentage') {
                            $coupon_discount_value = ($order_item->original_price * $i['quantity']) * $coupon->discount_value / 100;
                        } elseif ($coupon->coupon_discount_type->name == 'free_delivery') {
                            $coupon_discount_value = 0;
                        }
                        $coupon = (new Common())->setCouponForm($coupon);
                        if ($order_item->orderable_type == 'sub_product') {

                            $min_buying_condition = true;
                            $min_product = $min_brand = $min_sub_category = false;
                            $limitation_product = $limitation_brand = $limitation_sub_category = false;
                            if ($coupon->min_buying_condition_list != null) {
                                #for single min condtion
                                if ($coupon->min_buying_condition_list->product != null) {
                                    if ($order_item->orderable->product_id == $coupon->min_buying_condition_list->product) {
                                        $min_product = true;
                                    }
                                }
                                if ($coupon->min_buying_condition_list->brand != null) {
                                    // dd($coupon->min_buying_condition_list);
                                    if ($order_item->orderable->product->thing->brands[0]->id == $coupon->min_buying_condition_list->brand) {
                                        $min_brand = true;
                                    }
                                }
                                if ($coupon->min_buying_condition_list->sub_category != null) {
                                    // dd($coupon->min_buying_condition_list);
                                    if ($order_item->orderable->product->thing->sub_categories[0]->id == $coupon->min_buying_condition_list->sub_category) {
                                        $min_sub_category = true;
                                    }
                                }

                            }

                            #for single limitation
                            if ($coupon->limitation_list != null) {
                                if ($coupon->limitation_list->product != null) {
                                    // dd($coupon->min_buying_condition_list);
                                    if ($order_item->orderable->product_id == $coupon->limitation_list->product) {
                                        $limitation_product = true;
                                    }
                                }
                                if ($coupon->limitation_list->brand) {
                                    // dd($coupon->min_buying_condition_list);
                                    if ($order_item->orderable->product->thing->brands[0]->id == $coupon->limitation_list->brand) {
                                        $limitation_brand = true;
                                    }
                                }
                                if ($coupon->limitation_list->sub_category != null) {
                                    // dd($coupon->min_buying_condition_list);
                                    if ($order_item->orderable->product->thing->sub_categories[0]->id == $coupon->limitation_list->sub_category) {
                                        $limitation_brand = true;
                                    }
                                }
                            }
                            #end

                            #check if min buying condition is false ,subtract discount value from total value
                            if ($coupon->min_buying_condition_list != null) {
                                if (($min_product == false && $min_brand == false && $min_sub_category == false)) {
                                    $min_buying_condition = false;
                                    $order_item->total_value = $order_item->total_value + $coupon->discount_value;
                                    $discount_value = $discount_value - $coupon->discount_value;
                                    $order_item->coupon_id = null;
                                    // if($min_buying_condition==true && ($limitation_product==true || $limitation_brand==true || $limitation_sub_category==true)){
                                    //     $limitation_condition=true;
                                    // }
                                }
                            }
                            if ($coupon->limitation_list != null) {
                                if (($min_product == true || $min_brand == true || $min_sub_category == true) && $order_item->original_price < $coupon->discount_value) {
                                    $min_buying_condition = false;
                                    $order_item->total_value = $order_item->total_value + $coupon->discount_value;
                                    $discount_value = $discount_value - $coupon->discount_value;
                                    $order_item->coupon_id = null;
                                }
                                if ($min_buying_condition == true && ($limitation_product == false && $limitation_brand == false && $limitation_sub_category == false)) {
                                    #coupon is invalid
                                    $order_item->total_value = $order_item->total_value + $coupon->discount_value;
                                    $discount_value = $discount_value - $coupon->discount_value;
                                    $order_item->coupon_id = null;
                                }
                            }

                        }
                        // }
                    } else {
                        $coupon_discount_value = 0;
                    }
                    #end coupon region
                    $order_item->total_value = $total_value - $coupon_discount_value;
                    $order_item->save();
                    $this->addOrderQuantityToFloor($order_item, $order_item->orderable_id);

                }
            } else {
                $sub_total_discount_value = 0;
                $style_org_price = 0;
                foreach ($i['order_style_products'] as $order_style_sub) {
                    $o_sub = OrderStyleProduct::find($order_style_sub['id']);
                    if ($o_sub) {
                        // $update_style_order_item=$this->updateOrderItem($o_sub,$i);
                        $discount_value = $this->getDiscountValue($o_sub);
                        $sub_total_discount_value += $discount_value;
                        $o_sub->buying_quantity = $i['quantity'];
                        $o_sub->floor_id = $order_style_sub['floor_id'];
                        $o_sub->total_value = ($o_sub->original_price - $discount_value) * $i['quantity'];
                        $style_org_price += $o_sub->original_price;
                        $o_sub->save();
                        $this->addOrderQuantityToFloor($o_sub, $o_sub->sub_product_id);
                    }
                }
                $order_item = OrderItem::find($i['id']);
                if ($order_item) {
                    $discount_value = $this->getDiscountValue($order_item); //get Discount Amount of sub product or style
                    $total_discount_of_style = $discount_value + $sub_total_discount_value;
                    $order_item->original_price = $style_org_price;
                    $order_item->buying_quantity = $i['quantity'];
                    $order_item->total_value = ($order_item->original_price - $sub_total_discount_value - $discount_value) * $i['quantity'];
                    $order_item->save();
                }
            }
            #total
            $total_org_price += ($order_item->original_price * $i['quantity']);
            $dis_value = $i['type'] == 'style' ? $total_discount_of_style : $discount_value + $coupon_discount_value;
            $total_discount_value += $dis_value;
            $total_buying_quantity += $i['quantity'];
        }
        $tax = ($total_org_price / 100) * 5;
        $order = Order::find($request->order_id);
        $order->total_quantity = $total_buying_quantity;
        $order->status = $request->status;
        $order->total_original_price = $total_org_price;
        $order->total_discount_value = $total_discount_value;
        $order->tax = $tax;
        if ($coupon) {
            $coupon->coupon_discount_type == 'free_delivery' ? $order->is_delivery_free == 1 : 0;
        }
        $delivery_fee = $order->is_delivery_free == 1 ? 0 : $order->delivery_fee;
        $order->total_value = ($total_org_price - $total_discount_value) + $delivery_fee + $tax;
        $order->save();
    }
    public function deleteOrderItem($order_item_id)
    {
        DB::beginTransaction();
        try {
            $order_item = OrderItem::find($order_item_id);
            if ($order_item) {
                $discount_value = $this->getDiscountValue($order_item); //get Discount Amount of sub product or style
                $order = Order::find($order_item->order_id);
                if ($order) {
                    $order->total_original_price = $order->total_original_price - ($order_item->original_price * $order_item->buying_quantity);
                    $order->total_discount_value = $order->total_discount_value - ($discount_value * $order_item->buying_quantity);
                    $order->total_value = ($order->total_original_price - $order->total_discount_value) + $order->delivery_fee + $order->tax;
                    $order->total_quantity = $order->total_quantity - $order_item->buying_quantity;
                    $order->save();
                }

                if ($order_item->orderable_type == 'sub_product') {
                    $this->updateQuantityInFloor($order_item->floor_id, $order_item->orderable_id, $order_item->buying_quantity);
                }
                if ($order_item->orderable_type == 'style') {
                    foreach ($order_item->order_style_products as $osp) {
                        $this->updateQuantityInFloor($osp->floor_id, $osp->sub_product_id, $osp->buying_quantity);
                    }
                }
                if (empty($order->order_items)) {
                    $order->delete();
                }
            }
            DB::commit();
            return $order_item->delete();

        } catch (\Exception $e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }

    }

    public function updateQuantityInFloor($floor_id, $sub_product_id, $quantity)
    {
        $floor_sub = FloorSubProduct::where('floor_id', $floor_id)
            ->where('sub_product_id', $sub_product_id)->first();
        $floor_sub->update([
            'quantity' => $floor_sub->quantity + $quantity,
            'order_quantity' => $floor_sub->order_quantity - $quantity,
        ]);
        return $floor_sub;
    }

    public function saveDeliveryMan($request)
    {
        DB::beginTransaction();
        try {
            $order = Order::find($request->order_id);
            $order->delivery_man_id = $request->delivery_man_id;
            $order->status = $request->status;
            $order->save();
            if ($request->type == 'style') {
                $oi = OrderStyleProduct::find($request->order_item_id);
                $oi->assign_delivery_status = 'complete';
                $oi->save();
            }
            if ($request->type == 'sub_product') {
                $osp = OrderItem::find($request->order_item_id);
                $osp->assign_delivery_status = 'complete';
                $osp->save();
            }
            $this->subtractQtyAtFloor($request->floor_id, $request->sub_product_id, $request->qty);
            $notify = (new SaveNotification())->saveNotify($order, 'You order is assigned to delivery', 'order');
            if ($notify) {
                $notification = (new SaveNotification())->save($notify, Auth::user(), 'admin');

                $url = 'http://127.0.0.1:8000';
                $data = [
                    'id' => $notification->id,
                    'notification_count' => Notification::notificationIsRead(0)->countNotiForUser(),
                    'type' => $notification->notify->notifiable_type,
                    'order_id' => $order->order_id,
                    'order_status' => $order->status,
                    'order_date' => $order->updated_at,
                ];
                $user = User::find($order->user_id);
                $notification->toSingleDevice($user->token, 'Order ' . $order->status, 'Order ' . $order->status, null, $url, $data);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        return $order;

    }
    public function actionStatusInventoryOrder($request)
    {
        DB::beginTransaction();
        try {   

            $order = Order::with('order_items')->find($request->order_id);
            $order->delivery_man_id = $request->delivery_man_id;
            $order->status = $request->status;
            $order->save();
            foreach ($order->order_items as $oi) {
                if ($oi->orderable_type == 'style') {
                    $oi = OrderItem::find($oi->id);
                    $oi->assign_delivery_status = 'complete';
                    $oi->save();
                    foreach ($oi->order_style_products as $o_sub) {
                        $osp = OrderStyleProduct::find($o_sub->id);
                        $osp->assign_delivery_status = 'complete';
                        $osp->save();
                        $osp->floor_id != null ? $this->subtractQtyAtFloor($osp->floor_id, $osp->sub_product_id, $osp->buying_quantity) : responseStatus('Floor is null', 200);
                    }
                }
                if ($oi->orderable_type == 'sub_product') {
                    $oi = OrderItem::find($oi->id);
                    $oi->assign_delivery_status = 'complete';
                    $oi->save();
                    $oi->floor_id != null ? $this->subtractQtyAtFloor($oi->floor_id, $oi->orderable_id, $oi->buying_quantity) :
                    responseStatus('Floor is null', 200);

                }
                // $this->subtractQtyAtFloor($request->floor_id, $request->sub_product_id, $request->qty);
            }
            DB::commit();
            responseStatus('Delivering is successfully', 200);
            return $order;
        } catch (\Exception $e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
    }

    public function subtractQtyAtFloor($floor_id, $sub_product_id, $qty)
    {
        $floor_sub_product = (new Common())->getFloorSubProduct($floor_id, $sub_product_id);
        return $floor_sub_product->update([
            'quantity' => $floor_sub_product->quantity - $qty,
            'order_quantity' => $floor_sub_product->order_quantity - $qty,
        ]);
    }

    #original
    // public function actionStatus($request)
    // {

    //     #status=> received,confirmed,cancelled
    //     if($request->status=='delivering' ){
    //         $this->actionStatusInventoryOrder($request);
    //     }elseif($request->status=='delivered'){
    //         $order = Order::find($request->order_id);
    //         $order->status='delivered';
    //         $order->save();
    //     }
    //     else{
    //         $total_org_price = 0;
    //         $total_discount_value = 0;
    //         $total_buying_quantity = 0;
    //         DB::beginTransaction();
    //         try {
    //             $order = Order::find($request->order_id);
    //             $cal_total_value=(new CouponCalculation())->calTotalOriginalValue($request->items);
    //             $coupon_discount_value=0;
    //             $discount_value=0;
    //             foreach ($request->items as $i) {   
    //                 if ($i['type'] == 'sub_product') {
    //                     $order_item = OrderItem::find($i['id']);
    //                     if($order_item->orderable->product){
    //                         $product=$order_item->orderable->product;
    //                         $product->purchase_count+=1;
    //                         $product->save();
    //                     }
    //                     if ($order_item) {
    //                         $discount_value = $this->getDiscountValue($order_item) * $i['quantity'];
    //                         $order_item->buying_quantity = $i['quantity'];
    //                         $order_item->floor_id = $i['floor_id'];
    //                         #coupon calculation 
    //                         if(!is_null($order_item->coupon_id)){ 
    //                             if((new CouponCalculation())->calCouponDiscount($order_item->coupon,$order_item,$cal_total_value)){
    //                                 $coupon_discount_value=$order_item->coupon->discount_value;
    //                             }else{
    //                                 $order->coupon_id=null;
    //                             }
    //                         }
    //                         // $total_value = ($order_item->original_price* $i['quantity'])  - ($discount_value + $coupon_discount_value);
    //                         // dd($coupon_discount_value);
    //                         #end coupon 

    //                         #coupon_region for multiple limitation
    //                         // if ($order_item->coupon_id != null) {
    //                         //     $coupon = Coupon::find($order_item->coupon_id);
    //                         //     if ($coupon->coupon_discount_type->name == 'fixed_amount') {
    //                         //         $coupon_discount_value = $coupon->discount_value;
    //                         //     } elseif ($coupon->coupon_discount_type->name == 'percentage') {
    //                         //         $coupon_discount_value = ($order_item->original_price * $i['quantity']) * $coupon->discount_value / 100;
    //                         //     } elseif ($coupon->coupon_discount_type->name == 'free_delivery') {
    //                         //         $coupon_discount_value = 0;
    //                         //     }
    //                         //     $coupon = (new Common())->setCouponForm($coupon);
    //                         //     if ($order_item->orderable_type == 'sub_product') {
    //                         //         $min_buying_condition = true;
    //                         //         $min_product = $min_brand = $min_sub_category = false;
    //                         //         $limitation_product = $limitation_brand = $limitation_sub_category = false;
    //                         //         if ($coupon->min_buying_condition_list != null) {
    //                         //             #for single min condtion
    //                         //             if ($coupon->min_buying_condition_list->product != null) {
    //                         //                 if ($order_item->orderable->product_id == $coupon->min_buying_condition_list->product) {
    //                         //                     $min_product = true;
    //                         //                 }
    //                         //             }
    //                         //             if ($coupon->min_buying_condition_list->brand != null) {
    //                         //                 // dd($coupon->min_buying_condition_list);
    //                         //                 if ($order_item->orderable->product->thing->brands[0]->id == $coupon->min_buying_condition_list->brand) {
    //                         //                     $min_brand = true;
    //                         //                 }
    //                         //             }
    //                         //             if ($coupon->min_buying_condition_list->sub_category != null) {
    //                         //                 // dd($coupon->min_buying_condition_list);
    //                         //                 if ($order_item->orderable->product->thing->sub_categories[0]->id == $coupon->min_buying_condition_list->sub_category) {
    //                         //                     $min_sub_category = true;
    //                         //                 }
    //                         //             }
    //                         //         }

    //                         //         #for single limitation
    //                         //         if ($coupon->limitation_list != null) {
    //                         //             if ($coupon->limitation_list->product != null) {
    //                         //                 // dd($coupon->min_buying_condition_list);
    //                         //                 if ($order_item->orderable->product_id == $coupon->limitation_list->product) {
    //                         //                     $limitation_product = true;
    //                         //                 }
    //                         //             }
    //                         //             if ($coupon->limitation_list->brand) {
    //                         //                 // dd($coupon->min_buying_condition_list);
    //                         //                 if ($order_item->orderable->product->thing->brands[0]->id == $coupon->limitation_list->brand) {
    //                         //                     $limitation_brand = true;
    //                         //                 }
    //                         //             }
    //                         //             if ($coupon->limitation_list->sub_category != null) {
    //                         //                 // dd($coupon->min_buying_condition_list);
    //                         //                 if ($order_item->orderable->product->thing->sub_categories[0]->id == $coupon->limitation_list->sub_category) {
    //                         //                     $limitation_brand = true;
    //                         //                 }
    //                         //             }
    //                         //         }
    //                         //         #end

    //                         //         #check if min buying condition is false ,subtract discount value from total value
    //                         //         if ($coupon->min_buying_condition_list != null) {
    //                         //             if (($min_product == false && $min_brand == false && $min_sub_category == false)) {
    //                         //                 $min_buying_condition = false;
    //                         //                 $order_item->total_value = $order_item->total_value + $coupon->discount_value;
    //                         //                 $discount_value = $discount_value - $coupon->discount_value;
    //                         //                 $order_item->coupon_id = null;
    //                         //                 // if($min_buying_condition==true && ($limitation_product==true || $limitation_brand==true || $limitation_sub_category==true)){
    //                         //                 //     $limitation_condition=true;
    //                         //                 // }
    //                         //             }
    //                         //         }

    //                         //         if ($coupon->limitation_list != null) {
    //                         //             if (($min_product == true || $min_brand == true || $min_sub_category == true) && $order_item->original_price < $coupon->discount_value) {
    //                         //                 $min_buying_condition = false;
    //                         //                 $order_item->total_value = $order_item->total_value + $coupon->discount_value;
    //                         //                 $discount_value = $discount_value - $coupon->discount_value;
    //                         //                 $order_item->coupon_id = null;
    //                         //             }
    //                         //             if ($min_buying_condition == true && ($limitation_product == false && $limitation_brand == false && $limitation_sub_category == false)) {
    //                         //                 #coupon is invalid
    //                         //                 $order_item->total_value = $order_item->total_value + $coupon->discount_value;
    //                         //                 $discount_value = $discount_value - $coupon->discount_value;
    //                         //                 $order_item->coupon_id = null;
    //                         //             }
    //                         //         }
    //                         //     }
    //                         //     // }
    //                         // } else {
    //                         //     $coupon = null;
    //                         //     $coupon_discount_value = 0;
    //                         // }
    //                         #end coupon region
    //                         $order_item->total_value = ($order_item->original_price* $i['quantity'])  - ($discount_value + $coupon_discount_value);
    //                         $order_item->save();
    //                         // dd($order_item->total_value);
    //                         $this->addOrderQuantityToFloor($order_item, $order_item->orderable_id);
    //                     }
    //                 } else {
    //                     $sub_total_discount_value = 0;
    //                     $style_org_price = 0;
    //                     foreach ($i['order_style_products'] as $order_style_sub) {
    //                         $o_sub = OrderStyleProduct::find($order_style_sub['id']);
    //                         if ($o_sub) {
    //                             $discount_value = $this->getDiscountValue($o_sub) * $order_style_sub['quantity'];
    //                             $sub_total_discount_value += $discount_value;
    //                             $o_sub->buying_quantity = $i['quantity'];
    //                             $o_sub->floor_id = $order_style_sub['floor_id'];
    //                             $o_sub->total_value = ($o_sub->original_price - $discount_value) * $i['quantity'];
    //                             $style_org_price += $o_sub->original_price;
    //                             $o_sub->save();
    //                             $this->addOrderQuantityToFloor($o_sub, $o_sub->sub_product_id);
    //                         }
    //                     }
    //                     $order_item = OrderItem::find($i['id']);
    //                     if ($order_item) {
    //                         $discount_value = $this->getDiscountValue($order_item); //get Discount Amount of sub product or style
    //                         $total_discount_of_style = $discount_value + $sub_total_discount_value;
    //                         $order_item->original_price = $style_org_price;
    //                         $order_item->buying_quantity = $i['quantity'];
    //                         if(!is_null($order_item->coupon_id)){
    //                             if((new CouponCalculation())->calCouponDiscount($order_item->coupon,$order_item,$cal_total_value)){
    //                                 $coupon_discount_value=$order_item->coupon->discount_value;
    //                             }else{
    //                                 $order_item->coupon_id=null;
    //                             }
    //                         }
    //                         $total_value = (($order_item->original_price - $total_discount_of_style - $coupon_discount_value) * $i['quantity']);
    //                         // $order_item->total_value = ($order_item->original_price - $sub_total_discount_value - $discount_value) * $i['quantity'];
    //                         // if ($order_item->coupon_id != null) {
    //                         //     $coupon = Coupon::find($order_item->coupon_id);
    //                         //     if ($coupon->coupon_discount_type->name == 'fixed_amount') {
    //                         //         $coupon_discount_value = $coupon->discount_value;
    //                         //     } elseif ($coupon->coupon_discount_type->name == 'percentage') {
    //                         //         $coupon_discount_value = ($order_item->original_price * $i['quantity']) * $coupon->discount_value / 100;
    //                         //     } elseif ($coupon->coupon_discount_type->name == 'free_delivery') {
    //                         //         $coupon_discount_value = 0;
    //                         //     }
    //                         //     $coupon = (new Common())->setCouponForm($coupon);
    //                         //     $min_buying_condition = false;
    //                         //     $limitation_condition = false;
    //                         //     if ($coupon->min_buying_condition_list != null) {
    //                         //         #for single min condtion
    //                         //         if ($coupon->min_buying_condition_list->stylist != null) {
    //                         //             if ($order_item->orderable->thing->stylists[0]->id == $coupon->min_buying_condition_list->stylist) {
    //                         //                 $min_buying_condition = true;
    //                         //             }
    //                         //         }
    //                         //     }
    //                         //     #for single limitation
    //                         //     if ($coupon->limitation_list != null) {
    //                         //         if ($coupon->limitation_list->stylist != null) {
    //                         //             // dd($coupon->min_buying_condition_list);
    //                         //             if ($order_item->orderable->thing->stylists[0]->id == $coupon->limitation_list->stylist) {
    //                         //                 $limitation_condition = true;
    //                         //             }
    //                         //         }
    //                         //         if ($coupon->limitation_list->brand) {
    //                         //             // dd($coupon->min_buying_condition_list);
    //                         //             if ($order_item->orderable->thing->brands[0]->id == $coupon->limitation_list->brand) {
    //                         //                 $limitation_condition = true;
    //                         //             }
    //                         //         }
    //                         //         if ($coupon->limitation_list->sub_category != null) {
    //                         //             // dd($coupon->min_buying_condition_list);
    //                         //             if ($order_item->orderable->thing->series[0]->id == $coupon->limitation_list->series) {
    //                         //                 $limitation_condition = true;
    //                         //             }
    //                         //         }
    //                         //     }
    //                         //     #end
    //                         //     if ($coupon->min_buying_condition_list != null) {
    //                         //         if ($min_buying_condition == false) {
    //                         //             $order_item->total_value = $order_item->total_value + $coupon->discount_value;
    //                         //             $discount_value = $discount_value - $coupon->discount_value;
    //                         //             $order_item->coupon_id = null;
    //                         //             // if($min_buying_condition==true && ($limitation_product==true || $limitation_brand==true || $limitation_sub_category==true)){
    //                         //             //     $limitation_condition=true;
    //                         //             // }
    //                         //         }
    //                         //     }
    //                         //     if ($coupon->limitation_list != null) {
    //                         //         if ($min_buying_condition == true && $order_item->original_price < $coupon->discount_value) {
    //                         //             $min_buying_condition = false;
    //                         //             $order_item->total_value = $order_item->total_value + $coupon->discount_value;
    //                         //             $discount_value = $discount_value - $coupon->discount_value;
    //                         //             $order_item->coupon_id = null;
    //                         //         }
    //                         //         if ($min_buying_condition == true && $limitation_condition == false) {
    //                         //             #coupon is invalid
    //                         //             $order_item->total_value = $order_item->total_value + $coupon->discount_value;
    //                         //             $discount_value = $discount_value - $coupon->discount_value;
    //                         //             $order_item->coupon_id = null;
    //                         //         }
    //                         //     }
    //                         // } else {
    //                         //     $coupon = null;
    //                         //     $coupon_discount_value = 0;
    //                         // }
    //                         $order_item->total_value = $total_value ;
    //                         $order_item->save();
    //                     }
    //                 }

    //                 #total
    //                 $total_org_price += ($order_item->original_price * $i['quantity']);
    //                 $dis_value = $i['type'] == 'style' ? ($total_discount_of_style * $i['quantity'])  : $discount_value ;
    //                 $total_discount_value += $dis_value + $coupon_discount_value;
    //                 $total_buying_quantity += $i['quantity'];
    //             }
    //             // dd($total_org_price);
    //             $order->coupon_discount_value=!is_null($order->coupon_id) ? $order->coupon->discount_value : $coupon_discount_value;
    //             $order->total_quantity = $total_buying_quantity;
    //             $order->status = $request->status;
    //             $order->total_original_price = $total_org_price;
    //             $order->total_discount_value = $total_discount_value;
    //             $order->inventory_id=$request->inventory_id;
    //             $order->tax = 0;
    //             // if ($coupon) {
    //             //     $coupon->coupon_discount_type == 'free_delivery' ? $order->is_delivery_free = 1 : 0;
    //             // }
    //             $delivery_fee = $order->is_delivery_free == 1 ? 0 : $order->delivery_fee;
    //             $order->delivery_fee=$delivery_fee;
    //             // $order->total_value = ($total_org_price - ($total_discount_value+$coupon_discount_value)) + $delivery_fee;
    //             $order->save();
    //             #notification
    //             $notify = (new SaveNotification())->saveNotify($order, 'You received order confirmed', 'order');
    //             if ($notify) {
    //                 $notification = (new SaveNotification())->save($notify, Auth::user(), 'admin');
    //                 $url = 'http://127.0.0.1:8000';
    //                 $data = [
    //                     'id' => $notification->id,
    //                     'notification_count' => Notification::notificationIsRead(0)->countNotiForUser(),
    //                     'type' => $notification->notify->notifiable_type,
    //                     'order_id' => $order->order_id,
    //                     'order_status' => $order->status,
    //                     'order_date' => $order->updated_at,
    //                 ];
    //                 $user = User::findOrfail($order->user_id);
    //                 $notification->toMultipleDevice($user, 'Order ' . $order->status, 'Order ' . $order->status, null, $url, $data);
    //             }
    //             #end notification
    //             DB::commit();
    //         } catch (\Exception $e) {
    //             DB::rollback();
    //             responseStatus($e->getMessage(), 402);
    //             throw $e;
    //         }
    //         return $order;
    //     }
        
    // }
    #end original

}
