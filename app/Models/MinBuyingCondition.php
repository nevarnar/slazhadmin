<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinBuyingCondition extends Model
{
    use HasFactory;
    protected $table='min_buying_condition';
    protected $with=['buyable'];
    public $timestamps = false;
    protected $fillable=['coupon_id','buyable_id','buyable_type'];
    public function buyable(){
        return $this->morphTo();
    }
}
