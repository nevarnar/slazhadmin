<?php

namespace App\Models;

use App\Models\Thing;
use App\Models\UnitType;
use App\Models\SubProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Size extends Model
{
    use HasFactory;
    protected $fillable=['name','unit_type_id'];
    protected $with=['unit_type:id,name'];
    public function unit_type(){
        return $this->belongsTo(UnitType::class);
    }
    public function sub_product(){
        return $this->hasMany(SubProduct::class);
    }
    public function things(){
        return $this->morphToMany(Thing::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }
    public function list(){
        return Size::select(['id','name','unit_type_id'])->where('unit_type_id',2)->get();
    }
    public function nameByGetId($type,$value){
       $size= Size::where($type,$value)->first();
       return $size->id;
    }
}
