<?php

namespace App\Models;

use App\Models\Color;
use App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'name', 'type','color_id'
    ];
  
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function color(){
        return $this->belongsTo(Color::class);
    }
    public function getProductPhoto($id,$type,$color_id = null){
        return ProductPhoto::where(function($query) use($id,$type,$color_id) {
            $query->whereType($type)
                  ->where('color_id',$color_id)
                  ->where('product_id',$id);
       })->get();

    }
    public function deleteGallery($product_id,$type){
        ProductPhoto::whereType($type)->where('product_id',$product_id)->delete();
    }
}
