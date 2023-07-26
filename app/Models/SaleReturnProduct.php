<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturnProduct extends Model
{
    use HasFactory;

    protected $fillable=['id','sub_product_id','floor_id'];

    public function sub_product(){
        return $this->belongsTo(\App\Models\SubProduct::class);
    }

    public function floor(){
        return $this->belongsTo(\App\Models\Floor::class);
    }

}
