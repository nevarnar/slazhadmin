<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProductMeasurementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('measurements')->insert(['id'=>1, 'name'=>'Height']);
        DB::table('measurements')->insert(['id'=>2, 'name'=>'Hip']);
        DB::table('measurements')->insert(['id'=>3, 'name'=>'Legs']);

        DB::table('unit_types')->insert(['id'=>1, 'name'=>'Number']);
        DB::table('unit_types')->insert(['id'=>2, 'name'=>'Alphabetical']);

        DB::table('units')->insert(['id'=>1, 'unit_type_id'=>1, 'name'=>'mm']);
        DB::table('units')->insert(['id'=>2, 'unit_type_id'=>1, 'name'=>'cm']);
        DB::table('units')->insert(['id'=>3, 'unit_type_id'=>1, 'name'=>'in']);
    }
}
