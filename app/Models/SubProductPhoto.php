<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProductPhoto extends Model
{
    use HasFactory;
    protected $fillable=['name','type','color_id','product_id'];
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function color(){
        return $this->belongsTo(Color::class);
    }
    public function getSubProductPhoto($id,$type,$color_id ){
        // return 
        $sub=SubProductPhoto::where(function($query) use($id,$type,$color_id) {
            $query->whereType($type)
                  ->where('color_id',$color_id)
                  ->where('product_id',$id);
       })->get();
       return $sub;
    }
    public function getSubProductPhotoById($id){
        // return 
        $sub=SubProductPhoto::find($id);
        $subs=SubProductPhoto::whereName($sub->name)->get();
        return $subs;
    }
}
