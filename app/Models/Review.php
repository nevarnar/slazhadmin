<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Review extends Model
{
    use HasFactory;

    protected $fillable=['title','comment','rating','user_id','reviewable_id','reviewable_type'];

    public function reviewable(){
        return $this->morphTo();
    }
   
    public function user(){
        return $this->belongsTo(\App\Models\User::class);
    }

    public function scopeStatus($query, $type){
       return $query->whereStatus($type);   
    }
    
    public function scopeGetWithType($query, $type){
        return $query->where('reviewable_type',$type);
    }
}
