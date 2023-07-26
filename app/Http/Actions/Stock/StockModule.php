<?php

namespace App\Http\Actions\Stock;

use Illuminate\Support\Facades\DB;
use stdClass;

class StockModule
{
    public function actionStocks($params, $action)
    {
        $rowExists = $this->checkExist($params->floor_id, $params->sub_product_id);
        if ($rowExists) {
            $qty = $action === 'add' ? $rowExists->quantity + (int) $params->quantity : $this->checkAmount($rowExists->quantity,$params->quantity);
            if($action==='add'){
                $qty=$rowExists->quantity + (int) $params->quantity ;
            }else if($action==='replace'){
                $qty=$params->quantity;
            }else{
                if($rowExists->quantity >= (int) $params->quantity){    
                    $qty=$rowExists->quantity - (int) $params->quantity ;
                }else{
                    return responseStatus('Error!The quantity is higher than the maximum allowed quantity of inventory',302);
                }
            }
            return DB::table('floor_sub_product')
                ->where('floor_id', $params->floor_id)
                ->where('sub_product_id', $params->sub_product_id)
                ->update([
                    'quantity' => $qty,
                ]);
        } else {
            if($params->quantity!=null || $params->quantity!=0){
                return DB::table('floor_sub_product')->insert([
                    'floor_id' => $params->floor_id,
                    'sub_product_id' => $params->sub_product_id,
                    'quantity' => $params->quantity,
                ]);
            }
            
        }
    }

    public function checkAmount($org_qty,$new_qty){
        if($org_qty >= (int) $new_qty){
            return $org_qty-$new_qty;
        }
    }

    public function actionStock($sub_id,$floor_id,$qty,$action){
        $param=new stdClass();
        $param->sub_product_id=$sub_id;
        $param->floor_id=$floor_id;
        $param->quantity=$qty;
        $this->actionStocks($param,$action);
    }


    public function storeTransfer($transfer_id,$data){
        foreach($data as $d){
            DB::table('sub_product_transfer')->insert([
                'transfer_id' => $transfer_id,
                'floor_id' => $d->floor_id,
                'sub_product_id' => $d->sub_product_id,
                'quantity' => $d->quantity,
            ]);
        }
    }
    public function checkExist($floor_id, $sub_product_id)
    {
        return \App\Models\FloorSubProduct::getSubProductInFloor($sub_product_id,$floor_id)->first();
    }

}
