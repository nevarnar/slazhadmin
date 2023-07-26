<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponLimitation extends Model
{
    use HasFactory;

    protected $table='coupon_limitation';
    protected $with=['limitable'];
    public $timestamps = false;
    protected $fillable=['coupon_id','limitable_id','limitable_type'];
    public function limitable(){
        return $this->morphTo();
    }
}
