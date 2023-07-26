<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\NameTranslation;

use App\Models\Brand;
use App\Models\Supplier;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $with=['name_translations'];

    public function brands(){
        return $this->hasMany(Brand::class);
    }

    public function suppliers(){
        return $this->hasMany(Supplier::class);
    }

    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable');
    }
}
