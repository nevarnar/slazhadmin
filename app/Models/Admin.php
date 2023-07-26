<?php

namespace App\Models;


use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Admin extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;
    protected $fillable = ['user_name','full_name','phone_number','admin_type_id','email','password','facebook_id','google_id','address','device_token','inventory_id'];

    protected $with=['permissions'];

    public function setPasswordAttribute($value)
    {
        if (Hash::needsRehash($value)) {
            $value = Hash::make($value);
        }
        $this->attributes['password'] = $value;
    }
    public function scopeSetNullByInventoryId($query,$inv_id){
        $query->where('inventory_id',$inv_id);
    }
    public function admin_type(){
        return $this->belongsTo(\App\Models\AdminType::class);
    }
    // public function department(){
    //     return $this->belongsTo(\App\Models\Department::class);
    // }
    public function inventory(){
        return $this->belongsTo(\App\Models\Inventory::class)->withTrashed();
    }

    public function permissions(){
        return $this->belongsToMany(\App\Models\Permission::class,'admin_permission','admin_id','permission_id');
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['user_name'] = strtolower($value);
    }
    public function isSuperAdmin() : bool
    {
        return $this->admin_type_id==1;
    }

    // public function isInventoryManager(){
    //     foreach ($this->department()->get() as $dept)
    //     {
    //         if ($dept->name == 'Inventory')
    //         {
    //             return true;
    //         }
    //     }
    //     return false;
    // }
    // public function isAdmin(){
    //     foreach ($this->department()->get() as $dept)
    //     {
    //         if ($dept->name == 'Admin')
    //         {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    public function hasPermission($permission){
        // dd($this->permissions);
        if($this->permissions->contains('slug',$permission)){
            return true;
        }
        return false;
    }
}
