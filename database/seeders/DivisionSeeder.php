<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages=['en','mm'];
        $names=[
            ['eng_name'=>'Mandalay','mm_name'=>'မန်းတလေး'],
            ['eng_name'=>'Yandon','mm_name'=>'ရန်ကုန်'],
            ['eng_name'=>'Magwe','mm_name'=>'မကွေး'],
            ['eng_name'=>'Sagaing','mm_name'=>'စစ်ကိုင်း'],
        ];
        foreach($names as $k=>$n){
            $division=\App\Models\Division::create();
            if($division){
                foreach($languages as $l){
                    DB::table('name_translations')->insert([
                        'name'=>$l=='en' ? $n['eng_name']: $n['mm_name'],
                        'name_translationable_id'=>$division->id,
                        'name_translationable_type'=>'division',
                        'language_code'=>$l,
                    ]);
                }
            }
        }
    }
}
