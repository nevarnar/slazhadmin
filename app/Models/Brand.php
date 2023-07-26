<?php

namespace App\Models;

use App\Models\Thing;
use App\Models\Country;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\NameTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku_name', 'logo', 'photo', 'country_id','is_feature','is_women_feature'
    ];
    protected $with=['name_translations','suppliers'];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function things(){
        return $this->morphToMany(Thing::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }

    public function suppliers(){
        return $this->belongsToMany(Supplier::class, 'brand_supplier');
    }

    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable')->select(['id','name','language_code','name_translationable_id','name_translationable_type']);
    }
    public function scopeBySearchSku($query,$request){
        return $query->whereHas('name_translations', function ($qu) use ($request) {
             $qu->where('name', 'LIKE', '%' . $request->search_input . '%');
         })->orWhere('sku_name', 'LIKE', '%' . $request->search_input . '%');
 }
}
