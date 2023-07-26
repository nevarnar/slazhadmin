<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $type=['Super Admin','Admin'];
        foreach($type as $t){
            \App\Models\AdminType::create([
                'name'=>$t,
            ]);
        }
    }
}
