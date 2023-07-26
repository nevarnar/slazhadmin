<?php

namespace App\Models;

use App\Models\SaleReturnProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleReturn extends Model
{
    use HasFactory;

    protected $fillable=['sub_product_id','qty','status','amount','reason_id','description','orderitemable_id','orderitemable_type','order_id','floor_id','delivery_man_id'];

    public function sub_product(){
        return $this->belongsTo(\App\Models\SubProduct::class);
    }

    public function order(){
        return $this->belongsTo(\App\Models\Order::class);
    }
    public function reason(){
        return $this->belongsTo(\App\Models\Reason::class);
    }

    public function floor(){
        return $this->belongsTo(\App\Models\Floor::class);
    }

    public function delivery_man(){
        return $this->belongsTo(\App\Models\DeliveryMan::class);
    }


    public function orderitemable(){    
        return $this->morphTo();
    }
    public function sale_return_photos(){
        return $this->hasMany(SaleReturnPhoto::class)->select('id','sale_return_id','name');
    }

    public function sale_return_product(){
        return $this->hasOne(SaleReturnProduct::class)->select('id','sale_return_id','sub_product_id','floor_id');
    }
    public function saveSaleReturnProduct($data,$id)
    {
        // return $this->sale_return_product()->create($data);
        return $this->sale_return_product()->updateOrCreate(
            ['id' => $id],
            $data
        );
    }
}
