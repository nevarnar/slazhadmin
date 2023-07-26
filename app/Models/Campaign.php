<?php

namespace App\Models;

use App\Models\NameTranslation;
use App\Models\DescriptionTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Campaign extends Model
{
    use HasFactory;
    protected $fillable=[
        'start_date',
        'end_date',
        'photo',
    ];

    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable')->select(['id','name','language_code','name_translationable_id','name_translationable_type']);
    }

    public function description_translations(){
        return $this->morphMany(DescriptionTranslation::class, 'description_translationable')->select(['id','name','language_code','description_translationable_id','description_translationable_type']);
    }
    public function discount_sub_products(){
        return $this->belongsToMany(\App\Models\DiscountSubProduct::class,'campaign_discount_sub_product');
    }
}
