<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'address',
        'is_default',
        'township_id',
        'user_id',
        'phone_number'
    ];

    public function township(){
        return $this->belongsTo(\App\Models\Township::class)->select('id','division_id','delivery_fee');
    }
    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }
}
