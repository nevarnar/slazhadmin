<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SizeChartRegion;

class SizeChartRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions=['MM','US','UK','Asia','Chinese'];
        foreach($regions as $region){
            SizeChartRegion::create([
                'name'=>$region
            ]);
        }
    }
}
