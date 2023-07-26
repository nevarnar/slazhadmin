<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;
use App\Models\Variation;
use App\Models\NameTranslation;

class SubVariation extends Model
{
    use HasFactory;

    protected $fillable = [
        'variation_id'
    ];
    protected $with=['name_translations','variation'];

    public function products(){
        return $this->morphToMany(Product::class, 'productable')->withPivot('product_id', 'productable_id', 'productable_type');
    }

    public function variation(){
        return $this->belongsTo(Variation::class);
    }

    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable');
    }
    public function whereById($type,$id){
        return SubVariation::where($type,$id)->get();
    }
}
