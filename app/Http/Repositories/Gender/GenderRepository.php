<?php

namespace App\Http\Repositories\Gender;

use App\Models\Gender;
use App\Http\Repositories\Gender\GenderRepositoryInterface;

class GenderRepository implements GenderRepositoryInterface {

    private $select_data =  ['id','name'];

    public function list()
    {
        return Gender::select($this->select_data)->get();
    }

    public function details(Gender $Gender)
    {
        return $Gender;

    }
}