<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name','is_feature'];
    
    protected $with=['name_translations'];

    public function products(){
        return $this->morphToMany(Product::class, 'productable')->withPivot('product_id', 'productable_id', 'productable_type');
    }
    
    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable');
    }
}
