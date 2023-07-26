<?php

namespace App\Http\Actions\Product;

use Illuminate\Support\Facades\DB;

class FeaturedBrands
{
    public function run($sub){
        $brands =   DB::table('brands')
            ->join('name_translations', 'name_translations.name_translationable_id','=','brands.id')
            ->where('name_translations.name_translationable_type', 'brand')
            ->where('brands.is_available', 1)
            ->orderBy('name_translations.name')
            ->select('brands.id','brands.is_feature','brands.photo', DB::raw('brands.logo as icon'),
                'name_translations.name', 'name_translations.language_code')
            ->get()
            ->groupBy('is_feature')
            ->values();
        foreach ($brands as $brand){
            if(!$brand->isEmpty()){
                if($brand[0]->is_feature == 1 ){
                    $sub->feature_brands = $brand;
                }
                else{
                    $sub->brands = $brand;
                }
            }
        }
        return $sub;
    }
}
