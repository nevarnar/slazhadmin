<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturnPhoto extends Model
{
    use HasFactory;

    protected $fillable=['name','sale_return_id'];

    public function sale_return_id(){
        return $this->belongsTo(\App\Models\SaleReturn::class);
    }
}
