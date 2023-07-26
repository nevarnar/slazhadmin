<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedCoupon extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }
    
    public function coupon(){
        return $this->belongsTo(\App\Models\Coupon::class);
    }
}
