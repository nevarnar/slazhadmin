<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=[
        'order_id',
        'date',
        'total_original_price',
        'total_discount_value',
        'total_quantity',
        'is_delivery_free',
        'tax',
        'delivery_fee',
        'total_value',
        'payment_type_id',
        'user_id',
        'status',
        'address_id',
        'delivery_man_id',  
        'coupon_id',
        'inventory_id',
    ];
    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }
    public function coupon(){
        return $this->belongsTo(\App\Models\Coupon::class);
    }
    public function inventory(){
        return $this->belongsTo(\App\Models\Inventory::class);
    }
    public function address(){
        return $this->belongsTo(\App\Models\Address::class);
    }
    public function delivery_man(){
        return $this->belongsTo(\App\Models\DeliveryMan::class);
    }
    public function order_items(){
        return $this->hasMany(\App\Models\OrderItem::class);
    }
    public function payent_type(){
        return $this->belongsTo(\App\Models\PaymentType::class);
    }
}
