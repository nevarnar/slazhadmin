<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('seasons')
        ->insert(['id'=>1,'name'=>'Summer']);
        DB::table('seasons')
        ->insert(['id'=>2,'name'=>'Monsoon']);
        DB::table('seasons')
        ->insert(['id'=>3,'name'=>'Winter']);
    }
}
