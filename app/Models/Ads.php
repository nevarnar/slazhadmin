<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;
    protected $with=['name_translations','ads_type','adsable'];
    protected $fillable=['ads_type_id','mobile_photo','photo','link','title','text','adsable_type','adsable_id'];

    public function adsable(){
        return $this->morphTo();
    }

    public function ads_type(){
        return $this->belongsTo(\App\Models\AdsType::class);
    }

    public function name_translations(){
        return $this->morphMany(NameTranslation::class, 'name_translationable')->select(['id','name','language_code','name_translationable_id','name_translationable_type']);
    }

    public function checkMarketingAds(){
        foreach($this->ads_type()->get() as $t){
            if($t->name=='Marketing Message'){
                return true;
            }
        }
        return false;

    }
}
