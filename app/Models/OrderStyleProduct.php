<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStyleProduct extends Model
{
    use HasFactory;
    protected $with=['sub_product','floor'];
    protected $fillable=[
        'order_item_id',
        'original_price',
        'total_value',
        'is_delivery_free',
        'buying_quantity',
        'flash_sale_id',
        'sub_product_id',
        'discount_id',
        'floor_id',
    ];
    public function order_item(){
        return $this->belongsTo(\App\Models\OrderItem::class);
    }
    public function discount(){
        return $this->belongsTo(\App\Models\Discount::class);
    }
    public function floor(){
        return $this->belongsTo(\App\Models\Floor::class);
    }
    public function sub_product(){
        return $this->belongsTo(\App\Models\SubProduct::class);
    }
    public function flash_sale(){
        return $this->belongsTo(\App\Models\FlashSale::class);
    }
}
