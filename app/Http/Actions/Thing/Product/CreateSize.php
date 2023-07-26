<?php

namespace App\Http\Actions\Thing\Product;

use App\Http\Actions\Thing\KindableSave;
use App\Models\Size;

class CreateSize
{
    public function run($request , $thing )
        {
            if ($thing) {
                if ($request->isNumbering === "true") {
                    $sizes = explode(",", $request->size);
                    $size_collection = [];
                    foreach ($sizes as $s) {
                        $size_collection[] = Size::firstOrCreate(
                            ['name' => $s],
                            ['unit_type_id' => 1]
                        );
                    }
                    (new KindableSave())->save_unstablemodel($size_collection, $thing->sizes());
                } else {
                    $model_arr = [['name' => 'size', 'function' => $thing->sizes()]];
                    (new KindableSave())->save($request, $model_arr);
                }
            }
        }

}
