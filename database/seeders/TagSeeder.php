<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
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
        DB::table('tags')->insert(['id'=>1]);
                foreach($languages as $l){
                    DB::table('name_translations')->insert([
                        'name'=>$l=='en' ? 'Tag One': 'tag-one',
                        'name_translationable_id'=>1,
                        'name_translationable_type'=>'tag',
                        'language_code'=>$l,
                    ]);
                }
    }
}
