<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $names=['Defect','Wrong Size'];
        foreach($names as $name){
            \App\Models\Reason::create([
                'name'=>$name,
            ]);
        }
    }
}
