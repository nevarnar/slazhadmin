<?php

namespace App\Http\Repositories\FlashSale;

use Carbon\Carbon;
use App\Models\Discount;
use App\Models\FlashSale;
use App\Models\FlashSaleStyle;
use Illuminate\Support\Facades\DB;
use App\Models\FlashSaleSubProduct;
use App\Http\Actions\Inventory\Common;

class FlashSaleRepository implements FlashSaleInterface
{
    public function list($request){
       $flash_sale=FlashSale::with('flash_sale_sub_products','flash_sale_styles')->orderBy('id','desc')->get();
       return $flash_sale;
    }
    public function createOrUpdate($request){
        if(!$request->id){
            $this->checkFlashSaleExistOnDate($request);
        }
        $items = json_decode($request->flast_sale_items);
        $data = $request->all();
        DB::beginTransaction();
        try {
            if (!isset($request->id)) {
                $data['id'] = null;
            }
            $data['flashsaleable_type']=$request->type;
            // $data['quantity']= $request->is_unlimited === "true"? null : $request->quantity;
            $data['start_date'] = Carbon::parse($data['start_date'])->format('Y-m-d');
            $data['end_date'] = Carbon::parse($data['end_date'])->format('Y-m-d');
            $flash_sale=FlashSale::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
            if($flash_sale){
                foreach($items as $i){
                    if($request->type=='sub_product'){
                        $this->storeFlashSaleSubProduct($flash_sale,$i);
                    }
                    if($request->type=='style'){
                        $this->storeFlashSaleStyle($flash_sale,$i);
                    }
                }
            }
            DB::commit();
        } catch (\Exception$e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
    }

    public function checkFlashSaleExistOnDate($request){
        $start_date = convertDateFormat($request->start_date);
        $end_date = convertDateFormat($request->end_date);
        $flash_sale=FlashSale::orderBy('id','desc')
        ->where('flashsaleable_type',$request->type)
      
        ->where(function($q)use($request,$start_date){
            $q->whereDate('start_date','<=',$start_date)
            ->whereDate('end_date','>=',$start_date)
            ->where('is_available',1);

        })
        
        ->orWhere(function($q)use($start_date,$end_date,$request){
            $q->whereDate('start_date','<=',$start_date)
            ->where('is_available',1)
            ->whereDate('end_date','>=',$end_date);
        })
        ->first();
        if($flash_sale){
            responseStatus('Flash Sale Date is already created! Please try another date ',402);
        }
    }

    public function storeFlashSaleSubProduct($flash_sale,$item){
        FlashSaleSubProduct::create([
            'flash_sale_id'=>$flash_sale->id,
            'sub_product_id'=>$item->item->id,
            'discount_value'=>$item->discount_value,
            'quantity'=>$item->quantity,
            'max_buying_count'=>$item->max_buying_count,
        ]);
    }
    public function storeFlashSaleStyle($flash_sale,$item){
        FlashSaleStyle::create([
            'flash_sale_id'=>$flash_sale->id,
            'style_id'=>$item->item->id,
            'discount_value'=>$item->discount_value,
            'quantity'=>$item->quantity,
            'max_buying_count'=>$item->max_buying_count,
        ]);
    }

    public function details($flash_sale){
        $flash_sale->flashsaleable_type=='sub_product' ?
        $flash_sale->flash_sale_sub_products=$flash_sale->flash_sale_sub_products:$flash_sale->flash_sale_styles=$flash_sale->flash_sale_styles;
        if( $flash_sale->flashsaleable_type=='sub_product' ){
            foreach($flash_sale->flash_sale_sub_products as $sub){
                $sub->sub_product->flash_sale_item_id=$sub->id;
            }
        }
        if( $flash_sale->flashsaleable_type=='style' ){
            foreach($flash_sale->flash_sale_styles as $sub){
                $sub->style->flash_sale_item_id=$sub->id;
            }
        }
        return $flash_sale;
    }

    public function delete($flashsale){

    }

    public function deleteItem($request){
        if($request->type=='sub_product'){
             $flash_sale=FlashSaleSubProduct::find($request->id);
             if($flash_sale){
                return $flash_sale->delete();
             }
             responseStatus(" Item isn't found",404);
        }else{
            $flash_sale= FlashSaleStyle::find($request->id);
            if($flash_sale){
                return $flash_sale->delete();
             }
             responseStatus(" Item isn't found",404);
        }
    }


    public function validateSubProductForFlashSale($request){
        // $this->checkFlashSaleExistOnDate($request);
        $request->type=='sub_product' ? (new FlashSaleSubProduct())->checkSubProductExists($request->item['id'],$request->start_date,$request->end_date) : (new FlashSaleStyle())->checkStyleExists($request->item['id'],$request->start_date,$request->end_date);
       
        $this->checkFixedDiscount($request);
    }
    public function checkFixedDiscount($request){
        $start_date = convertDateFormat($request->start_date);
        $end_date = convertDateFormat($request->end_date);
        $this->checkQuantity($request);
        if (((new Discount())->checkDiscountExists($request->item['id'], $request->type, 1,$start_date,$end_date))) {
            $data = [$request->item];
            return responseStatus('Discount have been included in another discount promotion,Please Try Another one!', 402);
        }
    }
    public function compareQty($sub_qty,$request){
        if($request->quantity!=null){
            if(((int)$sub_qty) < $request->quantity){
                return responseStatus('Quantity is not enough,Please Try another!', 402);
            }
        }else{
           if($sub_qty<1 ){
            return responseStatus('Quantity is empty at inventory,Please Try another!', 402);
           }
        }
    }
    public function checkQuantity($request){
        if($request->quantity==null){
            $sub_qty=(new Common())->getsubProductQuantity($request->item['id']);
            if($sub_qty<1 ){
                return responseStatus('Quantity is empty at inventory,Please Try another!', 402);
               }
        }else{
            if($request->type==='sub_product'){
                $sub_qty=(new Common())->getsubProductQuantity($request->item['id']);
                $this->compareQty($sub_qty,$request);
            }else{

                foreach ($request->item['sub_products'] as $sub) {
                    $sub_qty=(new Common())->getsubProductQuantity($sub['id']);
                    $this->compareQty($sub_qty,$request);
                }
            }
        }

    }
}