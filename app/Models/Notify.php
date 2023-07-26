<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;
    protected $fillable=['title','date_time','notifiable_id','notifiable_type'];
    protected $with=['notifiable'];
    public function notifiable(){
        return $this->morphTo();
    }

}
