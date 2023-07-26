<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleSubProduct extends Model
{
    use HasFactory;

    protected $fillable=[
        'flash_sale_id',
        'sub_product_id',
        'discount_value',
        'quantity',
        'max_buying_count',
    ];

    protected $with=['flash_sale','sub_product.product.thing.brands'];

    public function sub_product(){
        return $this->belongsTo(\App\Models\SubProduct::class);
    }
    public function flash_sale(){
        return $this->belongsTo(\App\Models\FlashSale::class);
    }

    public function checkSubProductExists($sub_id,$start_date,$end_date){
        return $this->where('sub_product_id',$sub_id)
        ->whereHas('flash_sale',function($query)use($start_date,$end_date){

            // $query->whereBetween('start_date', [$start_date, $end_date])
            // ->orWhereBetween('end_date', [$start_date, $end_date]);
            // $query->where('is_available',1)
            $query->where(function($q)use($start_date){
                $q->whereDate('start_date','<=',$start_date)
                ->whereDate('end_date','>=',$start_date);
            })
            ->orWhere(function($q)use($start_date,$end_date){
                $q->whereDate('start_date','>=',$start_date)
                ->whereDate('end_date','>=',$end_date);
            });
        })->exists();
    }
}
