<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genders')
        ->insert(['id'=>1,'name'=>'Men']);
        DB::table('genders')
        ->insert(['id'=>2,'name'=>'Women']);
        DB::table('genders')
        ->insert(['id'=>13,'name'=>'Unisex']);
    }
}
