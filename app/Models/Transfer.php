<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Date;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable=['transfer_id','from_inventory_id','to_inventory_id','send_date','arrive_date','status'];
  
    protected $with=['sub_products'];
    // public function setDateAttribute( $value ) {
    //     $this->attributes['send_date'] = (new Carbon($value))->format('d/m/y');
    //   }
    public function from_inventory(){
        return $this->belongsTo(\App\Models\Inventory::class,'from_inventory_id','id');
    }
    public function to_inventory(){
        return $this->belongsTo(\App\Models\Inventory::class,'to_inventory_id','id');
    }
    public function sub_products(){
        return $this->belongsToMany(SubProduct::class,'sub_product_transfer')
        ->using(\App\Models\SubProductTransfer::class)
        ->withPivot('floor_id','quantity');
    }
}
