<?php

namespace App\Imports;

use App\Models\Division;
use App\Models\Township;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Http\Actions\NameTranslation\NameSaving;

class TownshipsImport implements ToModel
{
    public function model(array $row)
    {
      
        $languages=['en','mm'];
            $township=Township::create([
                'division_id'=>$row[0],
            ]);
            if($township){
                foreach($languages as $l){
                    DB::table('name_translations')->insert([
                        'name'=>$l=='en' ? $row[2]: $row[2],
                        'name_translationable_id'=>$township->id,
                        'name_translationable_type'=>'township',
                        'language_code'=>$l,
                    ]);
                }
            }
        return $township;
    }
}
