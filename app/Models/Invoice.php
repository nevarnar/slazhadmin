<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable=['invoice_no','supplier_id'];
    protected $with=['supplier'];
    public function supplier(){
        return $this->belongsTo(\App\Models\Supplier::class);
    }
    public function instocks(){
        return $this->hasOne(\App\Models\Stock::class)->latest();
    }
    public function stocks(){
        return $this->hasMany(\App\Models\Stock::class)->latest();
    }

    public function scopeByInventory($query,$request){
        return $query->whereHas('stocks.floor.shelf.inventory', function ($q) use ($request) {
            $q->where('id', $request->inventory_id);
        });
    }
}
