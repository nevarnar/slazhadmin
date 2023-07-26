<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Brand;
use App\Models\Country;
use App\Models\NameTranslation;
use App\Models\Product;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku_name', 'contact_name', 'phone_number', 'address', 'country_id'
    ];

    public function brands(){
        return $this->belongsToMany(Brand::class, 'brand_supplier');
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable');
    }

    public function products(){
        return $this->morphToMany(Product::class, 'productable')->withPivot('product_id', 'productable_id', 'productable_type');
    }
}
