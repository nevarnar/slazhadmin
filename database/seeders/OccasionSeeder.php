<?php

namespace Database\Seeders;

use App\Models\Occasion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OccasionSeeder extends Seeder
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
            ['eng_name'=>'Ocassion-1','mm_name'=>'O-1'],
            ['eng_name'=>'Occasion-2','mm_name'=>'0-2'],
        ];
        foreach($names as $k=>$n){
            $inserted_model=Occasion::create([
                'icon'=>null,
            ]);
            if($inserted_model){
                foreach($languages as $l){
                    DB::table('name_translations')->insert([
                        'name'=> $l=='en' ? $n['eng_name']: $n['mm_name'],
                        'name_translationable_id'=>$inserted_model->id,
                        'name_translationable_type'=>'occasion',
                        'language_code'=>$l,
                    ]);
                }
            }
        }
    }
}
