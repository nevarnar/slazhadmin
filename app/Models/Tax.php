<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tax extends Model
{
    use HasFactory;
    
    public function products(){
        return $this->morphToMany(Product::class, 'productable')->withPivot('product_id', 'productable_id', 'productable_type');
    }
}
