<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Township extends Model
{
    use HasFactory;
    protected $fillable=[
        'duration',
        'division_id',
        'delivery_fee',
    ];
    protected $with=[
        'name_translations',
    ];
    public function division(){
        return $this->belongsTo(\App\Models\Division::class)->select('id');
    }
    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable')->select(['id','name','language_code','name_translationable_id']);
    }
    public function scopeByDivision($query,$id){
        $query->whereHas('division',function($q)use($id){
            $q->whereId($id);
        });
    }
    public function scopeSearchTownship($query,$search_data){
        $query->whereHas('name_translations', function ($qu) use ($search_data) {
            $qu->where('name', 'LIKE', '%' . $search_data . '%');
        });
    }
    public function scopeSearchTownshipAndDivision($query,$search_data){
        $query->whereHas('name_translations', function ($qu) use ($search_data) {
            $qu->where('name', 'LIKE', '%' . $search_data . '%');
        })
        ->orWhereHas('division.name_translations', function ($qu) use ($search_data) {
            $qu->where('name', 'LIKE', '%' . $search_data . '%');
        });
    }

    
}
