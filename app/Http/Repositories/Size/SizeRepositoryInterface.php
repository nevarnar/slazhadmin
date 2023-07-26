<?php

namespace App\Http\Repositories\Size;

interface SizeRepositoryInterface {

    public function list($request);
    
    public function createOrUpdate($request);

    public function details($size);
}
