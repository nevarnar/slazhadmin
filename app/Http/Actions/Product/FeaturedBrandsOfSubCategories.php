<?php

namespace App\Http\Actions\Product;

use Illuminate\Support\Facades\DB;

class FeaturedBrandsOfSubCategories
{
    public function run($sub_category_ids)
    {
        $product_ids = DB::table('kindables')
            ->join('things', function ($join)  {
                $join->on('things.thingable_id','=','kindables.thing_id')
                    ->where('things.thingable_type', '=','product');
            })
            ->where('kindable_type','sub_category')
            ->whereIn('kindable_id',$sub_category_ids)
            ->pluck('thing_id');

        $brand_ids=  DB::table('kindables')
            ->where('kindable_type','brand')
            ->whereIn('thing_id',$product_ids)
            ->pluck('kindable_id');

        return  DB::table('brands')
            ->join('name_translations', 'name_translations.name_translationable_id','=','brands.id')
            ->where('name_translations.name_translationable_type', 'brand')
            ->where('brands.is_available', 1)
            ->orderBy('name_translations.name')
            ->whereIn('brands.id',$brand_ids)
            ->select('brands.id','brands.is_feature', DB::raw('brands.logo as icon'),
                'name_translations.name', 'name_translations.language_code')
            ->get();

    }
}
