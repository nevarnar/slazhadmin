<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StyleNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $languages=['en'];
        $names=[
            ['eng_name'=>'Style One'],
            ['eng_name'=>'Style Two'],
        ];
           
        foreach($names as $k=>$n){
            $style_name=\App\Models\StyleName::create();
            foreach($languages as $l){
                DB::table('name_translations')->insert([
                    'name'=>$n['eng_name'],
                    'name_translationable_id'=>$style_name->id,
                    'name_translationable_type'=>'style_name',
                    'language_code'=>$l,
                ]);
            }
        }
        
    }
}
