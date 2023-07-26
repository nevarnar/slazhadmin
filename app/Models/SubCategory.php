<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Category;
use App\Models\Measurement;
use App\Models\Product;
use App\Models\Variation;
use App\Models\NameTranslation;
use App\Models\UnitType;
use App\Models\Unit;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'icon', 'sku_name','is_feature'
    ];
    protected $with=['name_translations:id,name,language_code,name_translationable_id'];


    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function measurements(){
        return $this->belongsToMany(Measurement::class, 'measurement_sub_category');
    }

    public function things(){
        return $this->morphToMany(Thing::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }

    public function unit_types(){
        return $this->belongsToMany(UnitType::class, 'sub_category_unit_type');
    }
    
    public function units(){
        return $this->belongsToMany(Unit::class, 'sub_category_unit');
    }

    public function variations(){
        return $this->belongsToMany(Variation::class, 'sub_category_variation');
    }

    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable');
    }

    public function scopeBySearchSku($query, $request)
    {
        return $query->whereHas('name_translations', function ($qu) use ($request) {
            $qu->where('name', 'LIKE', '%' . $request->search_input . '%');
        })->orWhere('sku_name', 'LIKE', '%' . $request->search_input . '%');
    }
}
