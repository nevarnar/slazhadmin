<?php

namespace App\Http\Repositories\Supplier;

use App\Models\Supplier;

use App\Http\Actions\NameTranslation\NameSaving;
use App\Http\Actions\NameTranslation\NameSearching;

class SupplierRepository implements SupplierRepositoryInterface{

    private array $select_data = ['id','sku_name', 'contact_name', 'phone_number', 'address', 'country_id'];

    public function list($request)
    {
        $suppliers = Supplier::with(['name_translations:id,name,language_code,name_translationable_id','country'])->orderBy('id', 'desc')->select($this->select_data);
        if($request->search_input!=null || $request->search_input!=""){
            (new NameSearching())->searchName($suppliers,$request->search_input);
        }
        return $suppliers->get();
        // foreach ($suppliers as $supplier) {
        //     $supplier->country = array(
        //         "id" => $supplier->country->id,
        //         "name_translations" => $supplier->country->name_translations
        //     );

        //     $brand_array = array();
        //     foreach ($supplier->brands as $brand) {
        //         array_push($brand_array, array(
        //             $brand,
        //             $brand->name_translations
        //         ));
        //     }
        //     $supplier->brands = array(
        //         $brand_array
        //     );
        // }

        // return $suppliers;
    }

    public function createOrUpdate($request)
    {
        $data = $request->all();
        if (!isset($request->id)) {
            $data['id'] = null;
        }
        $brand_ids = JsonDecode($request->brand_ids);

        $supplier = Supplier::updateOrCreate(
            ['id'=> $data['id']],
            $data
        );

        if(isset($brand_ids)){
            $supplier->brands()->detach();
            $supplier->brands()->attach($brand_ids);
        }

        $json_name_data = JsonDecode($request->data);
        (new NameSaving())->run($json_name_data,$supplier);
        return $this->details($supplier);
    }

    public function details(Supplier $supplier)
    {
        $supplier->name_translations = $supplier->name_translations;
        $supplier->country = array(
            "id" => $supplier->country->id,
            "name_translations" => $supplier->country->name_translations
        );

        $brand_array = array();
        foreach($supplier->brands as $brand){
            array_push($brand_array, array(
                $brand,
                $brand->name_translations
            ));
        }

        $supplier->brands = array(
            $brand_array
        );

        return $supplier;
    }

    public function delete(Supplier $supplier)
    {
        (new NameSaving())->detachName($supplier,['mm','en']);
        return $supplier->delete();
    }

}
