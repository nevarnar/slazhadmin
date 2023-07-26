<?php

namespace App\Http\Actions\Product;

use Illuminate\Support\Facades\DB;

class SubCategories
{
    public function getSubCategoriesByCategory($category_id): \Illuminate\Support\Collection
    {
     return   DB::table('sub_categories')
            ->join('name_translations', 'name_translations.name_translationable_id','=','sub_categories.id')
            ->where('name_translations.name_translationable_type', 'sub_category')
            ->where('sub_categories.is_available', 1)
            ->where('category_id',$category_id)
            ->orderBy('name_translations.name')
            ->select('sub_categories.id','sub_categories.icon',DB::raw('0 as is_feature'),
                'name_translations.name', 'name_translations.language_code')
            ->get();
    }
}
