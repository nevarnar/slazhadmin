<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\SubCategory;

class Measurement extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function sub_categories(){
        return $this->belongsToMany(SubCategory::class, 'measurement_sub_category');
    }
}
