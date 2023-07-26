<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    use HasApiTokens;
    protected $table = 'users';
    protected $guard = 'sanctum';
    protected $fillable = [
        'email', 'name', 'phone_number', 'new_phone_number','image_name', 'avatar' ,
        'gender', 'date_of_birth', 'weight', 'height' , 'chest' , 'waist' , 'shoulder' , 'hip' ,
        'password', 'verify_code', 'is_verified', 'is_archive',
        'google_id','facebook_id'
        ];
    protected $hidden = ['password', 'remember_token'];

    public function setPasswordAttribute($value)
    {
        if (Hash::needsRehash($value)) {
            $value = Hash::make($value);
        }
        $this->attributes['password'] = $value;
    }
    public function scopeIsArchive($query,$value){
        $query->where('is_archive',$value);
    }

    public function favouriteProducts(){
        return $this->morphedByMany(Product::class,'favourites');
    }

    public function favouriteStyles(){
        return $this->morphedByMany(Style::class,'favourites');
    }


}
