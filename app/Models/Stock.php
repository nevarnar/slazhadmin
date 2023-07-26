<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable=['quantity','sub_product_id','floor_id','invoice_id'];
    protected $with=['sub_product','floor','invoice','sub_product.product.thing.brands','sub_product.product.thing.series'];
    public function sub_product(){
        return $this->belongsTo(\App\Models\SubProduct::class);
    }
    public function floor(){
        return $this->belongsTo(\App\Models\Floor::class);
    }
    public function invoice(){
        return $this->belongsTo(\App\Models\Invoice::class);
    }
    
}

