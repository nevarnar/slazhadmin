<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
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
        // $names=[
        //     ['eng_name'=>'Product-A','mm_name'=>'p-a'],
        // ];
        $product=\App\Models\Product::create([
            'price'=>3000,
            'is_available'=>1,
        ]);
        if($product){
            $thing=DB::table('things')->insert([
                'thingable_id'=>1,
                'thingable_type'=>'product',
            ]);
            if($thing){ 
                foreach($languages as $l){
                    DB::table('name_translations')->insert([
                        'name'=>$l=='en' ? 'Product-A': 'p-a',
                        'name_translationable_id'=>$product->id,
                        'name_translationable_type'=>'product',
                        'language_code'=>$l,
                    ]);
                    DB::table('description_translations')->insert([
                        'name'=>$l=='en' ? 'Desc': 'desc',
                        'description_translationable_id'=>$product->id,
                        'description_translationable_type'=>'product',
                        'language_code'=>$l,
                    ]);
                }
            }
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>1,
                'kindable_type'=>'color',
            ]);
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>4,
                'kindable_type'=>'color',
            ]);
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>1    ,
                'kindable_type'=>'brand',
            ]);
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>1,
                'kindable_type'=>'occasion',
            ]);
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>1,
                'kindable_type'=>'sub_category',
            ]);
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>1,
                'kindable_type'=>'sub_category',
            ]);
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>1,
                'kindable_type'=>'tag',
            ]);
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>1,
                'kindable_type'=>'gender',
            ]);
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>1,
                'kindable_type'=>'season',
            ]);
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>1,
                'kindable_type'=>'tax',
            ]);
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>1,
                'kindable_type'=>'sub_variation',
            ]);
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>1,
                'kindable_type'=>'series',
            ]);
            DB::table('kindables')->insert([
                'thing_id'=>1,
                'kindable_id'=>4,
                'kindable_type'=>'size',
            ]);
        }
    }
}
