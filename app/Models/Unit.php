<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\SubCategory;
use App\Models\UnitType;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'unit_type_id'
    ];

    public function products(){
        return $this->morphToMany(Product::class, 'productable')->withPivot('product_id', 'productable_id', 'productable_type');
    }

    public function sub_categories(){
        return $this->belongsToMany(SubCategory::class, 'sub_category_unit');
    }

    public function unit_type(){
        return $this->belongsTo(UnitType::class);
    }
}
