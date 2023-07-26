<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TownshipSeeder extends Seeder
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
        $names=[
            ['eng_name'=>'Aungmyethazan','mm_name'=>'အောင်မြေသာစံ'],
            ['eng_name'=>'Chanayethazan','mm_name'=>'ချမ်းအေးသာစံ'],
            ['eng_name'=>'Chanmyathazi','mm_name'=>'ချမ်းမြသာစည်'],
            ['eng_name'=>'Maha Aungmye','mm_name'=>'မဟာအောင်မြေ'],
            ['eng_name'=>'Pyigyidagun','mm_name'=>'ပြည်ကြီးတံခွန်မြို့နယ်'],
            ['eng_name'=>'Amarapura','mm_name'=>'အမရပူရ'],
            ['eng_name'=>'Patheingyi','mm_name'=>'ပုသိမ်ကြီး'],
        ];
        foreach($names as $k=>$n){
            $township=\App\Models\Township::create([
                'division_id'=>1,
                'delivery_fee'=>null,
            ]);
            if($township){
                foreach($languages as $l){
                    DB::table('name_translations')->insert([
                        'name'=>$l=='en' ? $n['eng_name']: $n['mm_name'],
                        'name_translationable_id'=>$township->id,
                        'name_translationable_type'=>'township',
                        'language_code'=>$l,
                    ]);
                }
            }
        }
    }
}
