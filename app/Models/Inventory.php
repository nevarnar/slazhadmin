<?php

namespace App\Models;

use App\Models\Shelf;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable=['sku','is_available'];
    protected $with=['name_translations'];
    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable')->select(['id','name','language_code','name_translationable_id','name_translationable_type']);
    }
    public function shelves(){
        return $this->hasMany(\App\Models\Shelf::class)->select('id','name','floor_number','inventory_id');
    }
    public function createShelf($shelf)
    {
        return $this->shelves()->create($shelf);
    }
    
}
