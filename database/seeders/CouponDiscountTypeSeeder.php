<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CouponDiscountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CouponDiscountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $types=['fixed_amount','percentage','free_delivery'];
        foreach($types as $t){
            CouponDiscountType::create([
                'name'=>$t,
            ]);
        }
    }
}
