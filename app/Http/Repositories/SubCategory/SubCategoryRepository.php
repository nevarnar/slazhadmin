<?php

namespace App\Http\Repositories\SubCategory;

use App\Http\Actions\Product\FeaturedBrands;
use App\Http\Actions\Product\SubCategoriesOfABrand;
use App\Http\Actions\Product\SubCategoriesOfACategory;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Route;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;


class SubCategoryRepository implements SubCategoryRepositoryInterface
{
    private $select_data=['id'];
    public function listQuery($request)
    {
            $sub_categories= SubCategory::with(['name_translations', 'measurements', 'unit_types','variations'])->orderBy('created_at', 'desc');
            if($request->search_input!=null || $request->search_input!=""){
                (new NameSearching())->searchName($sub_categories,$request->search_input);
            }
            return $sub_categories;
    }

    function list($request) {
            return $this->adjustSubCategories($this->listQuery($request)->get());
    }
    function availableList($request) {
     $route_name=Route::currentRouteName();
        if($route_name==='sub_category.variation'){
            return $this->adjustSubCategories($this->listQuery($request)->whereIsAvailable(1)->get());
        }else{
                return $this->adjustSubCategories($this->listQuery($request)->whereIsAvailable(1)->whereHas(
                   'variations',function($q){
                       $q->whereIsAvailable(1);
                   }
            )->get());
        }
    }

    public function getSubCategoryByCategory($request){
        $brand_id = $request->brand_id;
        $category_id = $request->category_id;
        $sub = new \stdClass();
        $sub->feature_brands = [];
        $sub->brands  = [];
        $sub->sub_categories = [];
        if($brand_id == 0 && $brand_id != null){
            return  (new FeaturedBrands())->run($sub);
        }
        if($category_id){
           return  (new SubCategoriesOfACategory())->run($category_id,$sub);
        }
        if($brand_id <> 0 && $brand_id != null ){
            return  (new SubCategoriesOfABrand())->run($brand_id,$sub);
        }
        return $sub;
    }

    public function adjustSubCategories($sub_categories){
        foreach($sub_categories as $sub_category){
            $sub_category->category = array(
                "id" => $sub_category->category->id,
                "name_translations" => $sub_category->category->name_translations
            );
        }
        return $sub_categories;
    }

    public function createOrUpdate($request)
    {
        $data = $request->all();
        if (isset($request->icon)) {
            $path = UploadImage($request, 'icon');
            $data['icon'] = $path;
            if(isset($request->id)){
                $get_name=SubCategory::find($request->id);
                DeleteImage($get_name->icon);
            }
        }

        if(!isset($request->id)){
            $data['id'] = null ;
        }

        $sub_category = SubCategory::updateOrCreate(
            ['id'=> $data['id']],
            $data
        );

        $measurement_ids = JsonDecode($request->measurement_ids);
        $sub_category->measurements()->detach();
        $sub_category->measurements()->attach($measurement_ids);
        $sub_category->unit_types()->detach();
        $sub_category->unit_types()->attach($request->unit_type_id);

        $sub_category->units()->detach();
        if(isset($request->unit_id)){
            $sub_category->units()->attach($request->unit_id);
        }

        $json_name_data = JsonDecode($request->data);
        (new NameSaving())->run($json_name_data, $sub_category);

        return $this->details($sub_category);
    }

    public function details(SubCategory $sub_category)
    {
        $sub_category->name_translations = $sub_category->name_translations;
        $sub_category->category = $sub_category->category;
        $sub_category->category->name_translations = $sub_category->category->name_translations;
        $sub_category->measurements = $sub_category->measurements;
        $sub_category->unit_types = $sub_category->unit_types;
        if(isset($sub_category->units)){
            $sub_category->units = $sub_category->units;
        }
        else{
            $sub_category->units = null;
        }

        return $sub_category;
    }

    public function delete(SubCategory $sub_category)
    {
        $sub_category->measurements()->detach();
        $sub_category->unit_types()->detach();
        $sub_category->units()->detach();
        DeleteImage($sub_category->icon);
        (new NameSaving())->detachName($sub_category, ['mm','en']);
        return $sub_category->delete();
    }
}
