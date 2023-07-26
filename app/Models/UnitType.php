<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\SubCategory;
use App\Models\Unit;

class UnitType extends Model
{
    use HasFactory;

    protected $fillable = [
       'name'
    ];

    public function sub_categories(){
        return $this->belongsToMany(SubCategory::class, 'sub_category_unit_type');
    }

    public function units(){
        return $this->hasMany(Unit::class);
    }
    public function sizes(){
        return $this->hasMany(Size::class);
    }
}
