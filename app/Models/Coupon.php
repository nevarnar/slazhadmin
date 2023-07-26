<?php

namespace App\Models;

use App\Models\CouponType;
use App\Models\CouponDiscountType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;
    protected $with=['name_translations'];
    protected $fillable=[
        'code',
        'start_date',
        'end_date',
        'discount_value',
        'count',
        'coupon_type_id',
        'coupon_discount_type_id',
        'min_buying_amount',
        'photo',
    ];

    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable')->select(['id','name','language_code','name_translationable_id','name_translationable_type']);
    }
    public function description_translations(){
        return $this->morphMany(DescriptionTranslation::class, 'description_translationable')->select(['id','name','language_code','description_translationable_id','description_translationable_type']);
    }
    
    public function coupon_type(){ 
        return $this->belongsTo(CouponType::class);
    }
   
    public function coupon_discount_type(){ 
        return $this->belongsTo(CouponDiscountType::class);
    }

    public function users(){
        return $this->belongsToMany(\App\Models\User::class,'coupon_user');
    }

    public function coupon_limitation(){
        return $this->hasMany(\App\Models\CouponLimitation::class);
    }

    public function min_buying_condition(){
        return $this->hasMany(\App\Models\MinBuyingCondition::class);
    }
    

}
