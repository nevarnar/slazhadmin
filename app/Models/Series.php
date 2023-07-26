<?php

namespace App\Models;

use App\Models\NameTranslation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    use HasFactory;
    protected $fillable = ['sub_category_id', 'type'];
    protected $with = ['brands', 'sub_category', 'name_translations'];

    public function sub_category()
    {
        return $this->belongsTo(\App\Models\SubCategory::class)->select('id', 'category_id', 'icon', 'sku_name');
    }

    public function name_translations()
    {
        return $this->morphMany(NameTranslation::class, 'name_translationable')->select(['id', 'name', 'language_code', 'name_translationable_id', 'name_translationable_type']);
    }

    public function things(){
        return $this->morphToMany(Thing::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }
    
    public function brands()
    {
        return $this->belongsToMany(\App\Models\Brand::class, 'brand_series')->select('id', 'sku_name', 'logo', 'photo', 'country_id');
    }

    public function scopeBySearchSku($query, $request)
    {
        return $query->whereHas('name_translations', function ($qu) use ($request) {
            $qu->where('name', 'LIKE', '%' . $request->search_input . '%');
        });
    }
}
