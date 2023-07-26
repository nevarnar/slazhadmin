<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSale extends Model
{
    use HasFactory;
    // protected $with=[
    // ];
    protected $fillable=['start_date','end_date','start_time','end_time','min_buying_amount','flashsaleable_type','is_available'];
  
    public function flash_sale_sub_products(){
        return $this->hasMany(\App\Models\FlashSaleSubProduct::class);
    }
    public function flash_sale_styles(){
        return $this->hasMany(\App\Models\FlashSaleStyle::class);
    }
}
