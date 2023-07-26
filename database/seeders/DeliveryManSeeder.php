<?php

namespace Database\Seeders;

use App\Models\DeliveryMan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeliveryManSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $languages=['en','mm'];
        $dm=DeliveryMan::create([
            'phone_number'=>'09494984848',
            'delivery_id'=>1,
        ]);
        if($dm){
            foreach($languages as $l){
                DB::table('name_translations')->insert([
                    'name'=>$l==='en' ? "Leo Murphy" : "Aster Mg Mg",
                    'name_translationable_id'=>$dm->id,
                    'name_translationable_type'=>'delivery_man',
                    'language_code'=>$l,
                ]);
            }
        }
    }
}
