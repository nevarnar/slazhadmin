<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\NameTranslation;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;


class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $languages=['en','mm'];
        $names=[
            ['eng_name'=>'Nike'],
            ['eng_name'=>'Adidas'],
            ['eng_name'=>'Hugo Boss']
        ];
        foreach($names as $k=>$n){
            $brand=Brand::create([
                'logo'=>null,
                'photo'=>null,
                'sku_name'=>$n['eng_name'],
                'country_id'=>1,
            ]);
            if($brand){
                foreach($languages as $l){
//                    DB::table('name_translations')->insert([
//                        'name'=>$l=='en' ? $n['eng_name']: $n['mm_name'],
//                        'name_translationable_id'=>$brand->id,
//                        'name_translationable_type'=>'brand',
//                        'language_code'=>$l,
//                    ]);
                    DB::table('name_translations')->insert([
                        'name'=> $n['eng_name'],
                        'name_translationable_id'=>$brand->id,
                        'name_translationable_type'=>'brand',
                        'language_code'=>$l,
                    ]);
                }
            }
        }

//        Brand::factory(2000)->create()->each(function ($brand){
//                NameTranslation::factory()->create([
//                    'name'=>Str::random(10),
//                    'language_code'=>'en',
//                    'name_translationable_id'=>$brand->id,
//                    'name_translationable_type'=>'brand',
//                ]);
//            NameTranslation::factory()->create([
//                'name'=>Str::random(10),
//                'language_code'=>'mm',
//                'name_translationable_id'=>$brand->id,
//                'name_translationable_type'=>'brand',
//            ]);
//        });

    }
}
