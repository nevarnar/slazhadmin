<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NameTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'name_translationable_id', 'name_translationable_type', 'language_code'
    ];
    public function name_translationable(){
        return $this->morphTo();
    }
    
}
