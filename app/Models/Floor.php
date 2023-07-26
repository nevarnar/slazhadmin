<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Floor extends Model
{
    use HasFactory;
    protected $fillable=['name','shelf_id'];
    // protected $with=['shelf.inventory'];
    public function shelf(){
        return $this->belongsTo(\App\Models\Shelf::class)->select('id','name','floor_number','inventory_id');
    }
    public function sub_products(){
        return $this->belongsToMany(\App\Models\SubProduct::class, 'floor_sub_product');
    }
}
