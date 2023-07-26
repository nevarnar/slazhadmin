<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function getHomeSliderAds(Request $request){
        $ads_count = 3 ;
        if($request->gender_id== 0){
         $ads = $this->getAds(1,$ads_count);
        }
        else if($request->gender_id == 1){
            $ads =  $this->getAds(2,$ads_count);
        }
        else{
            $ads = $this->getAds(3,$ads_count);
        }
        responseData('data',$ads,200);
    }

    public function getHomeAds(Request $request){
        $ads_count = 2 ;
        if($request->gender_id== 0){
            $ads = $this->getAds(4,$ads_count);
        }
        else if($request->gender_id == 1){
            $ads =  $this->getAds(5,$ads_count);
        }
        else{
            $ads = $this->getAds(6,$ads_count);
        }
        responseData('data',$ads,200);
    }

    public function getBannerAds(Request $request){
        $ads_count = 1 ;
        if($request->gender_id== 0){
            $ads = $this->getAds(7,$ads_count);
        }
        else if($request->gender_id == 1){
            $ads =  $this->getAds(8,$ads_count);
        }
        else{
            $ads = $this->getAds(9,$ads_count);
        }
        responseData('data',$ads,200);
    }

    protected function getAds($ads_type_id,$ads_count){
        return Ads::where('ads_type_id',$ads_type_id)->take($ads_count)->select('id','link','photo')->get();
    }
}
