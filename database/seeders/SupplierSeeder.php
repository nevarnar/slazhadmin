<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class SupplierSeeder extends Seeder
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

        $languages=['en','mm'];
        $names=[
            ['eng_name'=>'John','mm_name'=>'Martinez'],
            ['eng_name'=>'Henery','mm_name'=>'Messi'],
            ['eng_name'=>'Anthony Martial','mm_name'=>'Anthony Martial'],
        ];
        foreach($names as $k=>$n){
            $supplier=Supplier::create([
                'sku_name'=>$faker->regexify('[A-Z]{5}[0-4]{3}'),
                'contact_name'=>$faker->name,
                'phone_number'=>$faker->phoneNumber,
                'address'=>$faker->address,
                'country_id'=>$faker->numberBetween(1,4),
            ]);
            if($supplier){
                foreach($languages as $l){
                    DB::table('name_translations')->insert([
                        'name'=>$l=='en' ? $n['eng_name']: $n['mm_name'],
                        'name_translationable_id'=>$supplier->id,
                        'name_translationable_type'=>'supplier',
                        'language_code'=>$l,
                    ]);
                }
            }
        }
    }
}
