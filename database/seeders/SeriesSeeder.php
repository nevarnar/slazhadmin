<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $languages = ['en','mm'];
        $series = \App\Models\Series::create([
            'sub_category_id' => 1,
            'type'=>'product',
        ]);
        if ($series) {
            foreach ($languages as $l) {
                DB::table('name_translations')->insert([
                    'name' => $l == 'en' ? 'Series-A' : 'Series-B',
                    'name_translationable_id' => $series->id,
                    'name_translationable_type' => 'series',
                    'language_code' => $l,
                ]);
            }
            $series->brands()->sync([1]);
        }
    }
}
