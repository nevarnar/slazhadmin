<?php

namespace Database\Seeders;

use App\Models\AdsType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ads_types = ['Home Slider Ads All', 'Home Slider Ads Men', 'Home Slider Ads Women' ,
            'Home Ads All',  'Home Ads Men' ,  'Home Ads Women',
            'Home banner Ads All', 'Home banner Ads Men', 'Home banner Ads Women','Marketing Message'];
        foreach ($ads_types as $ads_type){
            AdsType::create([
                'name'=> $ads_type
            ]);
        }
    }
}
