<?php

namespace App\Http\Repositories\Country;

use App\Http\Repositories\Country\CountryRepositoryInterface;
use App\Models\Country;

class CountryRepository implements CountryRepositoryInterface {

    private $select_data =  ['id'];

    public function list()
    {
        return Country::with(['name_translations:id,name,language_code,name_translationable_id',
        ])
        ->whereHas('name_translations',function($q){
            $q->where('language_code','en')->orderBy('name','desc');
        })
       ->select($this->select_data)->get();
    }

    public function details(Country $country)
    {
        return $country;

    }
}