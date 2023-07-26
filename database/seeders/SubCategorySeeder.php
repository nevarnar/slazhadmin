<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $languages = ['en', 'mm'];
        $names = [
            ['eng_name' => 'Polo Shirt', 'mm_name' => 'Polo Shirt'],
            ['eng_name' => 'T-Shirt', 'mm_name' => 'တီရှပ်'],

        ];
        // ['eng_name'=>'Gym','mm_name'=>'gym shoe'],
        // ['eng_name'=>'Sport','mm_name'=>'အားကစား'],
        foreach ($names as $k => $n) {
            // DB::beginTransaction();
            // try {
                $inserted_model = SubCategory::create([
                    'category_id' => 2,
                    'icon' => null,
                    'sku_name' => $n['eng_name'],
                ]);
                if ($inserted_model) {
                    foreach ($languages as $l) {
                        DB::table('name_translations')->insert([
                            'name' => $l == 'en' ? $n['eng_name'] : $n['mm_name'],
                            'name_translationable_id' => $inserted_model->id,
                            'name_translationable_type' => 'sub_category',
                            'language_code' => $l,
                        ]);
                    }
                    DB::table('sub_category_unit_type')->insert([
                        'sub_category_id' => $inserted_model->id,
                        'unit_type_id' => 2,
                    ]);
                    DB::table('measurement_sub_category')->insert([
                        'sub_category_id' => $inserted_model->id,
                        'measurement_id' => 1,
                    ]);
                }
            // } catch (\Exception$e) {
            //     DB::rollback();
            //     responseStatus($e->getMessage(), 402);
            //     throw $e;
            // }
        }
    }
}
