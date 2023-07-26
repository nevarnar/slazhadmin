<?php

namespace Database\Seeders;

use App\Models\Floor;
use App\Models\Inventory;
use App\Models\Shelf;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $languages = ['en', 'mm'];
        $data = Inventory::create([
            'sku' => Str::random(10),
        ]);
        $shelves = ['Shelf-A', 'Shelf-B', 'Shelf-C', 'Shelf-D', 'Shelf-E'];
        if ($data) {
            foreach ($languages as $l) {
                DB::table('name_translations')->insert([
                    'name' => $l === 'en' ? "Inventory-1" : "Inventory-1",
                    'name_translationable_id' => $data->id,
                    'name_translationable_type' => 'inventory',
                    'language_code' => $l,
                ]);
            }
            foreach ($shelves as $shf) {
                $shelf = Shelf::create([
                    'name' => $shf,
                    'floor_number' => 4,
                    'inventory_id'=>$data->id
                ]);
                if ($shelf) {
                    for ($i = 1; $i <= $shelf->floor_number; $i++) {
                        Floor::create([
                            'name' => $shelf->name.'_'.$i,
                            'shelf_id' => $shelf->id,
                        ]);
                    }
                }
            }
        }
    }
}
