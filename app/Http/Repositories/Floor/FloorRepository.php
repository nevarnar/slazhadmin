<?php

namespace App\Http\Repositories\Floor;

use App\Http\Actions\Inventory\Common;

class FloorRepository implements FloorRepositoryInterface
{
    public function floorByInventory($inventory_id){
        return (new Common())->floorByInventory($inventory_id);
        // $shelves=\App\Models\Shelf::where('inventory_id',$inventory_id)->get();
        // $floor_arr=[];
        // if($shelves){
        //     foreach($shelves as $shelf){
        //         foreach($shelf->floors as $f){
        //             array_push($floor_arr,$f);
        //         }
        //     }
        // }
        // return $floor_arr;
    }
}
