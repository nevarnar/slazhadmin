<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\SubCategory;
use App\Models\SubVariation;
use App\Models\NameTranslation;

class Variation extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id'
    ];
    protected $with=['name_translations:id,name,language_code,name_translationable_id'];
    public function products(){
        return $this->morphToMany(Product::class, 'productable')->withPivot('product_id', 'productable_id', 'productable_type');
    }

    public function sub_categories(){
        return $this->belongsToMany(SubCategory::class, 'sub_category_variation');
    }

    public function sub_variations(){
        return $this->hasMany(SubVariation::class);
    }

    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable')->select(['id','name','language_code','name_translationable_id','name_translationable_type']);
    }
}
