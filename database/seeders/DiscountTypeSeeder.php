<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $names=['Fixed','Delivery Free'];
        foreach($names as $name){
            \App\Models\DiscountType::create([
                'name'=>$name,
            ]);
        }
    }
}
