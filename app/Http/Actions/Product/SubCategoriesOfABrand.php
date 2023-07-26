<?php

namespace App\Http\Actions\Product;

use Illuminate\Support\Facades\DB;

class SubCategoriesOfABrand
{
    public function run($brand_id, $sub){
        $product_ids = DB::table('kindables')
            ->join('things', function ($join)  {
                $join->on('things.thingable_id','=','kindables.thing_id')
                    ->where('things.thingable_type', '=','product');
            })
            ->where('kindable_type','brand')
            ->where('kindable_id',$brand_id)
            ->pluck('thing_id');

        $sub_category_ids =  DB::table('kindables')
            ->where('kindable_type','sub_category')
            ->whereIn('thing_id',$product_ids)
            ->pluck('kindable_id');

        $sub_categories =   DB::table('sub_categories')
            ->join('name_translations', 'name_translations.name_translationable_id','=','sub_categories.id')
            ->where('name_translations.name_translationable_type', 'sub_category')
            ->where('sub_categories.is_available', 1)
            ->orderBy('name_translations.name')
            ->whereIn('sub_categories.id',$sub_category_ids)
            ->select('sub_categories.id', DB::raw('sub_categories.icon'),
                'name_translations.name', 'name_translations.language_code')
            ->get();
        $sub->sub_categories = $sub_categories;
        return $sub;
    }
}
