<?php

namespace App\Http\Repositories\Gender;

use App\Models\Gender;

interface GenderRepositoryInterface {

    public function list();

    public function details(Gender $gender);
}
