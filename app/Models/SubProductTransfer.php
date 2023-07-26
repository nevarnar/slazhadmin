<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;


class SubProductTransfer extends Pivot
{
    use HasFactory;
    protected $table='sub_product_transfer';

    protected $with=['floor','transfer'];
    
    public function floor(){
        return $this->belongsTo(\App\Models\Floor::class);
    }
    public function transfer(){
        return $this->belongsTo(\App\Models\Transfer::class);
    }

}
