<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiscountSubProduct extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='discount_sub_product';
    protected $fillable=[
        'discount_id',
        'sub_product_id',
        'disount_value',
    ];
    protected $with=[
        'sub_product',
        'discount'
    ];
    public function discount(){
        return $this->belongsTo(\App\Models\Discount::class);
    }

    public function sub_product(){
        return $this->belongsTo(\App\Models\SubProduct::class);
    }

    public function scopeByDiscountType($query,$discount_type_id){
        return $query->whereHas('discount.discount_type',function($q)use($discount_type_id){
            $q->whereId($discount_type_id);
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

    public function scopeByModel($query,$type,$model){
        $query->whereHas($model,function($q)use($type){
            $q->where('id',$type);
        });
    }
    public function scopeBeforeEndDate($query){
        $query->whereHas('discount',function($q){
            $q->whereDate('end_date','>=',Carbon::now());
        });
    }

}
