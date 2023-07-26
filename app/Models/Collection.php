<?php

namespace App\Models;

use App\Models\CollectionPhoto;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;

  
    protected $fillable=['item_code','is_feature'];
    protected $with=['thing.colors'];
    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable')->select(['id','name','language_code','name_translationable_id','name_translationable_type']);
    }

    public function description_translations(){
        return $this->morphMany(DescriptionTranslation::class, 'description_translationable')->select(['id','name','language_code','description_translationable_id','description_translationable_type']);
    }

    public function thing(){
        return $this->morphOne(Thing::class, 'thingable');
    }
 
    public function collection_photo(){
        return $this->hasOne(CollectionPhoto::class)->select('id','collection_id','name');
    }
    public function styles(){
        return $this->belongsToMany(\App\Models\Style::class,'collection_style');
    }
    public function products(){
        return $this->belongsToMany(\App\Models\Product::class,'collection_product');
    }

    //*scope
    public function scopeSort($query,$type){
        $query->orderBy($type,'desc');
    }
    public function createCollectionPhoto($photo)
    {
        $this->collection_photo()->create($photo);
    }
    public static function boot() {
        parent::boot();
        static::deleting(function($collection) { // before delete() method call this
            //  DB::transaction(function () use ($collection) {
                $collection->thing->colors()->detach();
                $collection->thing->brands()->detach();
                $collection->thing->categories()->detach();
                $collection->thing->occasions()->detach();
                $collection->thing->genders()->detach();
                $collection->thing->seasons()->detach();
                $collection->thing->tags()->detach();
                $collection->name_translations()->delete();
                $collection->description_translations()->delete();
                $collection->thing()->delete();
            //  });
          
        });
    }
}
