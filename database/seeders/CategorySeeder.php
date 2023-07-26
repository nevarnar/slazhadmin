<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Category::factory(1)->create();
        $languages=['en','mm'];
        $names=[
            ['eng_name'=>'Shoe','mm_name'=>'ဖိနပ်'],
            ['eng_name'=>'Shirt','mm_name'=>'အကျ်ီ'],
            ['eng_name'=>'Belt','mm_name'=>'ခါးပတ်'],
        ];
        foreach($names as $k=>$n){
            $category=Category::create([
                'icon'=>null,
                'type'=>'product',
                'gender_id'=>1,
            ]);
            if($category){
                foreach($languages as $l){
                    DB::table('name_translations')->insert([
                        'name'=> $l=='en' ? $n['eng_name']: mb_convert_encoding($n['mm_name'],"UTF-8", "auto"),
                        'name_translationable_id'=>$category->id,
                        'name_translationable_type'=>'category',
                        'language_code'=>$l,
                    ]);
                }
            }
        }
    }
}
