<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $type=['Cash On Delivery','Other'];
        foreach($type as $t){
            \App\Models\PaymentType::create([
                'name'=>$t,
            ]);
        }
    }
}
