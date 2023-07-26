<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Color::factory(3)->create();
        $color_codes=['#FF00001','#008000','#0000FF','#000000','#FFFFFF'];
        $sku_names=[
            '#red-FF0000',
            '#green-008000',
            '#blue-0000FF',
            '#black-000000',
            '#white-FFFFFF'
        ];
        $languages=['en','mm'];
        $names=[
            ['eng_name'=>'Red','mm_name'=>'အနီရောင်'],
            ['eng_name'=>'Green','mm_name'=>'အစိမ်းရောင်'],
            ['eng_name'=>'Blue','mm_name'=>'အပြာရောင်'],
            ['eng_name'=>'Black','mm_name'=>'အနက်ရောင်'],
            ['eng_name'=>'White','mm_name'=>'အဖြူရောင်']
        ];
        foreach($names as $k=>$c){
            $color=Color::create([
                'color_code'=>$color_codes[$k],
                'sku_name'=>$sku_names[$k],
                'icon'=>null,
            ]);
            if($color){
                foreach($languages as $l){
                    DB::table('name_translations')->insert([
                        'name'=>$l==='en' ? $c['eng_name'] : $c['mm_name'],
                        'name_translationable_id'=>$color->id,
                        'name_translationable_type'=>'color',
                        'language_code'=>$l,
                    ]);
                }
            }
        }
    }
}
