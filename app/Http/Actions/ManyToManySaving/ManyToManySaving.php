<?php

namespace App\Http\Actions\ManyToManySaving;

class ManyToManySaving
{

    public function saveManytoMany($model,$array){
        return $model->sync($array);
    }
}
