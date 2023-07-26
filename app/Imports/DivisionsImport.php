<?php

namespace App\Imports;

use App\Models\Division;
use App\Models\Township;
use App\Models\Translation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Http\Actions\NameTranslation\NameSaving;

class DivisionsImport implements ToModel
{
    public function model(array $row)
    {
      
        $languages=['en','mm'];
            $division=Division::create();
            if($division){
                foreach($languages as $l){
                    DB::table('name_translations')->insert([
                        'name'=>$l=='en' ? $row[0]: $row[0],
                        'name_translationable_id'=>$division->id,
                        'name_translationable_type'=>'division',
                        'language_code'=>$l,
                    ]);
                }
            }
            return $division;
    }
}