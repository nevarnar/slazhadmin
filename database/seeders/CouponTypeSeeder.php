<?php

namespace Database\Seeders;

use App\Models\CouponType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CouponTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $types=['public','private','count'];
        foreach($types as $t){
            CouponType::create([
                'name'=>$t,
            ]);
        }
    }
}
