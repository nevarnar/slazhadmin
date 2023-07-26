<?php

namespace App\Models;

use App\Models\Thing;
use App\Models\SubProduct;

use App\Models\NameTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory;

    protected $fillable = [
        'color_code', 'sku_name', 'icon'
    ];
    protected $with=['name_translations:id,name,language_code,name_translationable_id'];
    
    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable');
    }
    public function things(){
        return $this->morphToMany(Thing::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }
    public function sub_products(){
        return $this->hasMany(SubProduct::class);
    }
    public function list(){
        return Color::select(['id','color_code','sku_name','icon'])->get();
    }
}
