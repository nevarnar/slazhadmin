<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'icon',
        'type',
        'gender_id',
    ];

 
    protected $with=['name_translations','gender'];

    public function sub_categories(){
        return $this->hasMany(SubCategory::class);
    }


    public function products(){
        return $this->morphToMany(Product::class, 'productable')->withPivot('product_id', 'productable_id', 'productable_type');
    }

    public function gender(){
        return $this->belongsTo((\App\Models\Gender::class));
    }


    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable');
    }

    public function scopeIsAvailable($query,$value){
        $query->where('is_available',$value);
    }
}
