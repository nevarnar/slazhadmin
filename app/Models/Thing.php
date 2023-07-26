<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Thing extends Model
{
    use HasFactory;
    protected $fillable=['thingable_id','thingable_type'];
    public function thingable(){
        return $this->morphTo();
    }
    public function products(){
        return $this->morphedByMany(Product::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type')->select('id','sku_name','logo','photo','country_id');
    }
     # reltion with kindable 
    public function brands(){
        return $this->morphedByMany(Brand::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type')->select('id','sku_name','logo','photo','country_id');
    }

    public function categories(){
        return $this->morphedByMany(Category::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }

    public function ads(){
        return $this->morphedByMany(Ads::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }

    public function genders(){
        return $this->morphedByMany(Gender::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }
    public function occasions(){
        return $this->morphedByMany(Occasion::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type')->select('id','icon');
    }
    public function seasons(){
        return $this->morphedByMany(Season::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }
    public function sizes(){
        return $this->morphedByMany(Size::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type')
        ->selectRaw('sizes.*')
        ->select('id','name','unit_type_id')
        ->orderByRaw(DB::raw("
            CASE name
                   WHEN 'XXS' THEN 1
                   WHEN 'XS' THEN 2
                   WHEN 'S' THEN 3
                   WHEN 'M' THEN 4
                   WHEN 'L' THEN 5
                   WHEN 'XL' THEN 6
                   WHEN 'XXL' THEN 7
         ELSE 7 END ASC"));
    }
    public function colors(){
        return $this->morphedByMany(Color::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type')->select('id','color_code','sku_name','icon');
    }

    public function sub_categories(){
        return $this->morphedByMany(SubCategory::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type')->select('id','category_id','icon','sku_name');
    }
    
    public function sub_products(){
        return $this->morphedByMany(SubProduct::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type')->select('id','sku','product_id','size_id','color_id','is_available');
    }

    public function sub_variations(){
        return $this->morphedByMany(SubVariation::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type')->select('id','variation_id');
    }

    public function suppliers(){
        return $this->morphedByMany(Supplier::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }
    public function tags(){
        return $this->morphedByMany(Tag::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }

    public function units(){
        return $this->morphedByMany(Unit::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }

    public function variations(){
        return $this->morphedByMany(Variation::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type')->select('id');
    }
    public function taxes(){
        return $this->morphedByMany(Tax::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }

    public function series(){
        return $this->morphedByMany(\App\Models\Series::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }
    public function stylists(){
        return $this->morphedByMany(\App\Models\StyleName::class, 'kindable')->withPivot('thing_id', 'kindable_id', 'kindable_type');
    }


    public static function boot() {
        parent::boot();
        static::deleting(function($model) { // before delete() method call this
            // $model->col
            //  $model->colors->each->delete();
            //  $model->brands()->each->delete();
            //  $model->occasions()->each->delete();
        });
    }

    #end relation ship with kindable
}
