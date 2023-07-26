<?php

namespace App\Models;

use App\Models\Thing;
use App\Models\StylePhoto;
use App\Models\NameTranslation;
use App\Models\DescriptionTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Style extends Model
{
    use HasFactory;
    protected $fillable=['is_available','item_code','type','is_feature','view_count'];
    protected $with=['name_translations','thing.categories','thing.brands','feature_photos','thing.genders','products'];
    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable')->select(['id','name','language_code','name_translationable_id','name_translationable_type']);
    }
    public function description_translations(){
        return $this->morphMany(DescriptionTranslation::class, 'description_translationable')->select(['id','name','language_code','description_translationable_id','description_translationable_type']);
    }
    public function thing(){
        return $this->morphOne(Thing::class, 'thingable');
    }
    public function products(){
        return $this->belongsToMany(\App\Models\Product::class,'product_style')->withPivot('color_id');
    }
    public function style_photos(){
        return $this->hasMany(StylePhoto::class)->select('id','style_id','name','type');
    }
    public function feature_photos(){
        return $this->hasOne(StylePhoto::class)->select('id','style_id','name')->where('type','feature_photo');
    }
    public function createStylePhoto($style_photo)
    {
        $this->style_photos()->create($style_photo);
    }
    public function updateStylePhotoPhoto($style_photo,$id)
    {
        $this->style_photos()->whereId($id)->update($style_photo);
    }
    public function scopeGetType($query,$type){
      $query->where('type',$type);
    }
    public function scopeIsAvailable($query,$value){
        $query->where('is_available',$value);
    }

    public function feature_photo()
    {
        return $this->style_photos()->where('type','feature_photo')->pluck('name')->first();
    }

    public function favouriteUser()
    {
        return $this->morphToMany(User::class, 'favourites');
    }

    public function reviews(){
        return $this->morphMany(Review::class,'reviewable')->where('status','approved')->with('user:id,name')->latest()->take(3);
    }

    public function scopeBySearchSku($query,$request){
            return $query->whereHas('name_translations', function ($qu) use ($request) {
                 $qu->where('name', 'LIKE', '%' . $request->search_input . '%');
             })->orWhere('item_code', 'LIKE', '%' . $request->search_input . '%');
     }

    public function flashSale()
    {
        return $this->hasMany(FlashSaleStyle::class);
    }
    // public function total_product_prices(){
    //     return $this->belongsToMany(\App\Models\Product::class,'product_style')->whereHas('products.sub_products.product_prices',function($q){
    //         $q->sum('price');
    //     });
    // }
}


