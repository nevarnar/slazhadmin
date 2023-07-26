<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\NameTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class NameTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         NameTranslation::factory()->count(20)->create();
    }
}       
