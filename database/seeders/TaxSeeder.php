<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('taxes')->insert(['id'=>1,'country'=>'none','amount'=>0]);
        DB::table('taxes')->insert(['id'=>2,'country'=>'myanmar','amount'=>5]);

    }
}
