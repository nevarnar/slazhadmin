<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'price', 'is_available', 'sku','view_count','size_guide_id','purchase_count'
    ];

    protected $with = [
        'name_translations',
        'product_photo',
        'thing.sub_categories',
        'thing.genders',
        'sub_product_photos',
    ];

    public function size_guide(){
        return $this->belongsTo(\App\Models\SizeGuide::class);
    }

    public function styles(){
        return $this->belongsToMany(\App\Models\Style::class,'product_style')->withPivot('color_id');
    }

    #for product photo and gallery
    public function product_photos()
    {
        return $this->hasMany(ProductPhoto::class)->select('id', 'product_id', 'color_id', 'name', 'type');
    }
    #end

    #for only one product photo
    public function product_photo()
    {
        return $this->hasOne(ProductPhoto::class)->select('product_id', 'type', 'name')->where('type', 'photo');
    }
    #end

    public function sub_product_photos()
    {
        return $this->hasMany(SubProductPhoto::class)->select('id', 'product_id', 'color_id', 'name', 'type');
    }

    public function name_translations()
    {
        return $this->morphMany(NameTranslation::class, 'name_translationable')->select(['id', 'name', 'language_code', 'name_translationable_id', 'name_translationable_type']);
    }

    public function description_translations()
    {
        return $this->morphMany(DescriptionTranslation::class, 'description_translationable')->select(['id', 'name', 'language_code', 'description_translationable_id', 'description_translationable_type']);
    }

    public function sub_products()
    {
        return $this->hasMany(SubProduct::class)->select('id', 'sku', 'is_available', 'product_id', 'color_id', 'size_id');
    }

    public function thing()
    {
        return $this->morphOne(Thing::class, 'thingable');
    }

    public function createProductPhoto($product_photo)
    {
        $this->product_photos()->create($product_photo);
    }
    #sub product create
    public function createSubProductPhoto($sub_product_photo)
    {
        $this->sub_product_photos()->create($sub_product_photo);
    }

    public function createSubProduct($sub_product, $id)
    {
        return $this->sub_products()->updateOrCreate(
            ['id' => $id],
            $sub_product
        );
    }

    public function updateProductPhoto($product_photo, $type, $color_id = null)
    {
        $this->product_photos()->where(function ($query) use ($type, $color_id) {
            $query->whereType($type)
                ->where('color_id', $color_id);
        })->update($product_photo);
    }

    public function updateSubProductPhoto($sub_product_photo, $type, $color_id)
    {
        $this->sub_product_photos()->where(function ($query) use ($type, $color_id) {
            $query->whereType($type)
                ->where('color_id', $color_id);
        })->update($sub_product_photo);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable')->where('status', 'approved')->with('user:id,name')->latest();
    }

    public function scopeSort($query, $type)
    {
        return $query->orderBy($type, 'desc');
    }

    public function scopeWhereSubProductColorId($query, $color_id)
    {
        return $query->with(['sub_products' => function ($q) use ($color_id) {
            $q->availableSizeByColor($color_id);
        }]);
    }

    public function scopeWhereThingColorId($query, $color_id)
    {
        return $query->with(['thing.colors' => function ($q) use ($color_id) {
            $q->whereId($color_id);
        }]);
    }

    public function scopeWhereCategoryId($query, $category_id)
    {
        return $query->whereHas('thing.sub_categories', function ($q) use ($category_id) {
            $q->whereId($category_id);
        });
    }

    public function favouriteUser()
    {
        return $this->morphToMany(User::class, 'favourites');
    }

}
