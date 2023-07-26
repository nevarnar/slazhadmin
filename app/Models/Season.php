<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function products(){
        return $this->morphToMany(Product::class, 'productable')->withPivot('product_id', 'productable_id', 'productable_type');
    }
}
