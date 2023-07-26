<?php

namespace App\Imports;

use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class CountryImport implements ToModel
{
    public function model(array $row)
    {
        $languages=['en','mm'];
        $country=Country::create();
        if($country){
            foreach($languages as $l){
                DB::table('name_translations')->insert([
                    'name'=>$l=='en' ? $row[0]: $row[0],
                    'name_translationable_id'=>$country->id,
                    'name_translationable_type'=>'country',
                    'language_code'=>$l,
                ]);
            }
        }
        return $country;
    }
}
