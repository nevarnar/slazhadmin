<?php

namespace App\Http\Repositories\Brand;

use Exception;
use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;

class BrandRepository implements BrandRepositoryInterface
{

    private $select_data = ['id', 'sku_name', 'logo', 'photo', 'country_id','is_available','is_feature','is_women_feature',];
    public function listQuery(){
        return Brand::with('name_translations:id,name,language_code,name_translationable_id','suppliers')
            ->orderBy('created_at', 'desc')->select($this->select_data);
    }
    function list($request) {
        $query= $this->listQuery();
        if($request->search_input!=null || $request->search_input!=""){
            (new NameSearching())->searchName($query,$request->search_input);
        }
        return $query->get();
    }
    function availableList($request) {
       return $this->listQuery()->whereIsAvailable(1)->get();
    }

    public function createOrUpdate($request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            if (isset($request->logo)) {
                $path = UploadImage($request, 'logo');
                $data['logo'] = $path;
                if (isset($request->id)) {
                    $brand = Brand::find($request->id);
                    DeleteImage($brand->logo);
                }
            }
            if (isset($request->photo)) {
                $path = UploadImage($request, 'photo');
                $data['photo'] = $path;
                if (isset($request->id)) {
                    $brand = Brand::find($request->id);
                    DeleteImage($brand->photo);
                }
            }
            if (!isset($request->id)) {
                $data['id'] = null;
            }
            $brand = Brand::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
            $json_name_data = JsonDecode($request->data);
            (new NameSaving())->run($json_name_data, $brand);
            DB::commit();
        } catch(\Exception $e){
            DB::rollback();
            responseStatus($e->getMessage(),402);
            throw $e;
        }
        return $this->details($brand);
    }

    public function details(Brand $brand)
    {
        $brand->name_translations = $brand->name_translations;
        $brand->country = array(
            "id" => $brand->country->id,
            "name_translations" => $brand->country->name_translations,
        );
        return $brand;
    }

    public function delete(Brand $brand)
    {
        DeleteImage($brand->logo);
        DeleteImage($brand->photo);
        (new NameSaving())->detachName($brand, ['mm', 'en']);
        return $brand->delete();
    }

    //Mobile API


    public function getBrands(){
        return  Brand::with('name_translations:id,name,language_code,name_translationable_id')
            ->select('id', 'logo', 'photo','is_feature','is_women_feature')
            ->where('is_available',1)
            ->get()
            ->groupBy('is_feature')
            ->values();
    }
}
