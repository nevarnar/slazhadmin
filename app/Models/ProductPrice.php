<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;
    protected $fillable=['price','sub_product_id'];
    
    public function sub_product(){
        return $this->belongsTo('App\Models\SubProduct');
    }
}
