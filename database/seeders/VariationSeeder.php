<?php

namespace Database\Seeders;

use App\Models\SubVariation;
use App\Models\Variation;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VariationSeeder extends Seeder
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
            ['eng_name' => 'Variation One ', 'mm_name' => 'V-1'],
            ['eng_name' => 'Variation Two ', 'mm_name' => 'V-2'],
        ];
        $subs = [
            [
                ['eng_name' => ' Sub Vairation One ', 'mm_name' => 'Sub-1'],
                ['eng_name' => 'Sub Variation Two', 'mm_name' => 'Sub-2'],
            ],
            [
                ['eng_name' => ' Sub Vairation Three ', 'mm_name' => 'Sub-3'],
                ['eng_name' => 'Sub Variation Four', 'mm_name' => 'Sub-4'],
            ],
        ];

        foreach ($names as $k => $n) {
            $inserted_model = Variation::create();
            if ($inserted_model) {
                foreach ($languages as $l) {
                    DB::table('name_translations')->insert([
                        'name' => $l == 'en' ? $n['eng_name'] : $n['mm_name'],
                        'name_translationable_id' => $inserted_model->id,
                        'name_translationable_type' => 'variation',
                        'language_code' => $l,
                    ]);
                }
                foreach ($subs as $sub) {
                    $sub_inserted_model = SubVariation::create([
                        'variation_id' => $inserted_model->id,
                    ]);
                    if ($sub_inserted_model) {
                        foreach ($languages as $l) {
                            DB::table('name_translations')->insert([
                                'name' => $l == 'en' ? $sub[$k]['eng_name'] : $sub[$k]['mm_name'],
                                'name_translationable_id' => $sub_inserted_model->id,
                                'name_translationable_type' => 'sub_variation',
                                'language_code' => $l,
                            ]);
                        }
                    }
                }
                $inserted_model->sub_categories()->attach($k + 1);
            }
        }
    }
}
