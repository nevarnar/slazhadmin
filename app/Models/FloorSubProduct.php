<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloorSubProduct extends Model
{
    use HasFactory;
    public  $timestamps=false;
    protected $table='floor_sub_product';
    protected $fillable=['quantity','sub_product_id','floor_id','order_quantity'];
    protected $with=['sub_product','sub_product.product.thing.brands','sub_product.product.thing.series'];
    public function sub_product(){  
        return $this->belongsTo(\App\Models\SubProduct::class);
    }
    public function floor(){
        return $this->belongsTo(\App\Models\Floor::class)
        ->whereHas('shelf', function ($q) {
           $q->withTrashed();
        });
    }
    public function scopeBySubProduct($query,$request){
        $query->whereHas('sub_product', function ($q)use($request) {
            $q->whereHas('product', function ($qa)use($request) {
                $qa->where('is_available', 1)
                ->orderBy('id','asc')
                ->whereHas('name_translations', function ($qu) use ($request) {
                    $qu->where('name', 'LIKE', '%' . $request->search_input . '%');
                });
            })
            ->orWhere('sku', 'LIKE', '%' . $request->search_input . '%');
        });
    }
    public function scopeByStyleSubProduct($query,$request){
        $query->whereHas('sub_product', function ($q)use($request) {
            $with='product.'.$request->rs_type;
            $q->whereHas($with, function ($qa)use($request) {
                // $qa->where('is_available', 1)
                // ->orderBy('id','asc')
                // ->whereHas('name_translations', function ($qu) use ($request) {
                //     $qu->where('name', 'LIKE', '%' . $request->search_input . '%');
                // });
                $qa->whereHas('name_translations', function ($qb) use ($request) {
                    $qb->where('name', 'LIKE', '%' . $request->search_input . '%');
                });
            })->orWhere('sku', 'LIKE', '%' . $request->search_input . '%');
        });
    }

    public function scopeSubProductBySeriesAndBrand($query,$request){
        $query->whereHas('sub_product', function ($q)use($request) {
            $with = 'product.thing.' . $request->promotion_type;
            $q->whereHas($with, function ($qa)use($request){
                // $qa->whereHas($with, function ($qb) use ($request) {
                    $qa->where('kindable_id', $request->promotion_category);
                // });
            });
        });
    }
    
    public function scopeStyleBySeriesAndBrand($query,$request){
        
    }

    public function scopeSortBySubProduct($query){  
        $query->whereHas('sub_product', function ($q) {
            $q->whereHas('product', function ($qa){
                $qa->where('is_available', 1)->orderBy('id','asc');
            });
        });
    }

    public function scopeByModel($query,$type,$model){
        $query->whereHas($model,function($q)use($type){
            $q->where('id',$type);
        });
    }

    public function scopeGetSubProductInFloor($query,$sub_id,$f_id){
        $query->where('sub_product_id', $sub_id)
        ->where('floor_id',$f_id);
    }
}
