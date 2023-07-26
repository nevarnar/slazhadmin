<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubProduct extends Model
{
    use HasFactory;

    protected $fillable = ['sku','is_available','product_id','color_id','size_id'];

    protected $with=['color','size','product_prices','product'];

    public function product(){
        return $this->belongsTo(Product::class)->select('id','is_available','price');
    }
    public function size(){
        return $this->belongsTo(Size::class)->orderBy('name','asc')->select('id','name','unit_type_id');
    }
    public function color(){
        return $this->belongsTo(Color::class)->select('id','color_code','sku_name','icon');
    }
    public function product_prices(){
        return $this->hasOne(ProductPrice::class)->latest('created_at')->select('price','sub_product_id');
    }

    // public function floor_sub_products(){
    //     return $this->hasOne(FloorSubProduct::class);
    // }
    public function createProductPrice($product_price){
        return $this->product_prices()->create($product_price);
    }
    public function scopeAvailableSizeByColor($query,$value){
        return $query->where([
            ['color_id',$value],
            ['is_available',1]
        ]);
    }
    public function scopeSearch($query,$request){
       $query->whereHas('product', function ($q)use($request) {
            $q->where('is_available', 1)
             ->whereHas('name_translations', function ($qu) use ($request) {
                $qu->where('name', 'LIKE', '%' . $request->search_input . '%');
            });
        })
        ->orWhere('sku', 'LIKE', '%' . $request->search_input . '%');
    }

    public function scopeIsAvailable($query,$value){
        $query->where('is_available',$value);
    }
    public function scopeProductIsAvailable($query){
        $query->whereHas('product',function($q){
            $q->where('is_available',1);
        });
    }

    public function flashSale()
    {
        return $this->hasMany(FlashSaleSubProduct::class);
    }

    public function flash_sale_sub_products(){
        return $this->hasMany(\App\Models\FlashSaleSubProduct::class);
    }
   
}
