<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        //
        $permissions=['Product Information Management','Inventory Management','Order Management','Customer Support Management','Admin Management','Promotion Management'];
        foreach($permissions as $p){
            Permission::create([
                'name'=>$p,
                'slug'=>Str::slug($p),
            ]);
        }
    }
}
