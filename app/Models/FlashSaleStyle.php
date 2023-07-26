<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashSaleStyle extends Model
{
    use HasFactory;
    protected $fillable=[
        'flash_sale_id',
        'style_id',
        'discount_value',
        'quantity',
        'max_buying_count',
    ];
    protected $with=['style'];
    public function flash_sale(){
        return $this->belongsTo(\App\Models\FlashSale::class);
    }
    public function style(){
        return $this->belongsTo(\App\Models\Style::class);
    }
    public function checkStyleExists($style_id,$start_date,$end_date){
        return $this->where('style_id',$style_id)
        ->whereHas('flash_sale',function($query)use($start_date,$end_date){
            // $query->whereBetween('start_date', [$start_date, $end_date])
            // ->orWhereBetween('end_date', [$start_date, $end_date]);
            $query->where('is_available',1)
            ->where(function($q)use($start_date){
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
