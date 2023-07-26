<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialAuth extends Model
{
    protected $fillable = ['social_id','social_driver','user_id'];
}
