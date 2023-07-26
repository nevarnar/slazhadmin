<?php

namespace App\Http\Actions\Product;

class SubCategoriesOfACategory
{
    public function run($category_id, $sub){
        $sub_categories =   (new SubCategories())->getSubCategoriesByCategory($category_id);
        $sub_category_ids = collect($sub_categories)->pluck('id')->unique()->values();
        $brands = (new FeaturedBrandsOfSubCategories())->run($sub_category_ids);
        $sub->feature_brands = $brands;
        $sub->sub_categories  = $sub_categories;
        return $sub;
    }

}
