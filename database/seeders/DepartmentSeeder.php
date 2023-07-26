<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $name=['Admin','Management','Inventory','Sales','Customer Service'];
        foreach($name as $n){
            Department::create([
                'name'=>$n,
            ]);
        }
    }
}
