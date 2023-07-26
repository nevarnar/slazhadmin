<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //
        $faker = Faker::create();

        $invoice=Invoice::create([
            'invoice_no'=>$faker->regexify('[A-Z]{5}[0-4]{3}'),
            'supplier_id'=>1
        ]);

        if($invoice){
            for($i=0;$i<=5;$i++){
                \App\Models\Stock::create([
                    'quantity'=>10,
                    'sub_product_id'=>[1,2],
                    'floor_id'=>$faker->numberBetween(1,4),
                    'invoice_id'=>$invoice->id,
                ]);
            }
           
        }
    }
}
