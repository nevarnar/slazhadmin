<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;

    protected $fillable=[
        'start_date',
        'end_date',
        'start_time',
        'is_flash_sale',
        'discount_value',
        'quantity',
        'discount_type_id',
        'discountable_id',
        'discountable_type',
        'min_buying_amount',
    ];
    protected $with=[
        'discount_type',
        // 'discountable',
    ];
    public function discount_type(){
        return $this->belongsTo(\App\Models\DiscountType::class);
    }
    // public function discount_sub_products(){
    //     return $this->hasMany(\App\Models\DiscountSubProduct::class);
    // }

    public function discountable(){
        return $this->morphTo();
    }
    public function scopeByDiscountType($query,$discount_type_id){
        return $query->whereHas('discount_type',function($q)use($discount_type_id){
            $q->whereId($discount_type_id);
        });
    }
    public function checkDiscountExists($id,$type=null,$discount_type_id=null,$start_date,$end_date){
        $type=$type=='style' ? 'style' :'sub_product';
       return $this::where('discountable_id',$id)
        ->where('discountable_type',$type)
        ->when($discount_type_id!=null,function($query)use($discount_type_id){
            $query->where('discount_type_id',$discount_type_id);
        })
        // ->where(function($q)use($start_date,$end_date){
        //     $q->whereBetween('start_date', [$start_date, $end_date])
        //     ->orWhereBetween('end_date', [$start_date, $end_date]);
        // })
        ->where(function($q)use($start_date,$end_date){
            $q->whereDate('start_date','<=',$start_date)
            ->whereDate('end_date','>=',$start_date)
            ->orWhere(function($q)use($start_date,$end_date){
                $q->whereDate('start_date','>=',$start_date)
                ->whereDate('end_date','>=',$end_date);
            });
        })
      
        ->exists();
        // if($discount_type_id!=3){
        //     $query->whereIn('discount_type_id',[1,2]);
        // }
        // else{
        //     $query->where('discount_type_id',$discount_type_id);
        // }
        // return $query->exists();
     }
     public function getIdByType($id,$type=null,$discount_type_id=null){
        $type=$type=='style' ? 'style' :'sub_product';
        return $this::where('discountable_id',$id)
        ->where('discountable_type',$type)
        ->where('discount_type_id',$discount_type_id)->first();
        // if($discount_type_id!=3){
        //     $query->whereIn('discount_type_id',[1,2]);
        // }
        // else{
            // $query->where('discount_type_id',$discount_type_id);
        // }
        // return $query->first();
     }

     public function scopeWithSubProduct($query,$id,$type){
        $query->where('discountable_id',$id)
        ->where('discountable_type',$type)
        ->whereDate('end_date','>=',Carbon::today());
     }

    public function scopeWithSubProducts($query,$ids,$type){
        $query->whereIn('discountable_id',$ids)
            ->where('discountable_type',$type)
            ->whereDate('end_date','>=',Carbon::today());
    }

     public function scopeDeliveryFree($query){
        $query->whereHas('discount_type',function($q){
            $q->where('name','Delivery Free');
        });
     }
     public function scopeFixedOrPercentage($query){
        $query->whereHas('discount_type',function($q){
            $q->where('name','Fixed')
            ->orWhere('name','Percentage');
        });
     }

     public function scopeGetFlashSaleItem($query){
        $query->where('is_flash_sale',1)
        ->whereDate('end_date','>=',Carbon::today());
     }
}
