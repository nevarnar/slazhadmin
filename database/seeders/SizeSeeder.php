<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes=['XXS','XS','S','M','L','XL','XXL','3XL'];
        foreach($sizes as $s){
            Size::create([
                'name'=>$s,
                'unit_type_id'=>2
            ]);
        }
    }
}
