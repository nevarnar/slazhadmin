<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StyleName extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    
    protected $with=['name_translations'];
    
    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable');
    }
}
