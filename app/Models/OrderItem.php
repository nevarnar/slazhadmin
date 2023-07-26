<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $with=['orderable','floor'];
    protected $fillable=[
       
        'order_id',
        'original_price',
        'total_value',
        'is_delivery_free',
        'buying_quantity',
        'flash_sale_id',
        'discount_id',
        'orderable_type',
        'orderable_id',
        'floor_id',
        'coupon_id',
    ];
    public function order(){
        return $this->belongsTo(\App\Models\Order::class);
    }
    public function coupon(){
        return $this->belongsTo(\App\Models\Coupon::class);
    }
    public function orderable(){    
        return $this->morphTo();
    }
    public function order_style_products(){
        return $this->hasMany(\App\Models\OrderStyleProduct::class);
    }
    public function discount(){
        return $this->belongsTo(\App\Models\Discount::class);
    }
    public function floor(){
        return $this->belongsTo(\App\Models\Floor::class);
    }
    public function flash_sale(){
        return $this->belongsTo(\App\Models\FlashSale::class);
    }
}
