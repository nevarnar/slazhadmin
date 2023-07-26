<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shelf extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=['name','inventory_id','floor_number'];
    protected $with=['floors'];
    public function inventory(){
        return $this->belongsTo(\App\Models\Inventory::class)->select('id','sku');
    }
    public function floors(){
        return $this->hasMany(\App\Models\Floor::class)->select('id','name','shelf_id');
    }
    public function createFloor($floor)
    {
        return $this->floors()->create($floor);
    }

    public function scopeGetByInventory($query,$inventory_id){
        return $query->where('inventory_id', $inventory_id);
    }
}
