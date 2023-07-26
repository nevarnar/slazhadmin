<?php

namespace App\Models;

use App\Models\Delivery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeliveryMan extends Model
{
    use HasFactory;

    protected $fillable=['phone_number','delivery_id'];
    protected $with=['name_translations','delivery'];

    public function delivery(){
        return $this->belongsTo(Delivery::class)->select(['id','name']);
    }

    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable')->select(['id','name','language_code','name_translationable_id','name_translationable_type']);
    }
}
