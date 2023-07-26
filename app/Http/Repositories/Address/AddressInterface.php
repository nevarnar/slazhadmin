<?php

namespace App\Http\Repositories\Address;

interface AddressInterface
{
    public function listByUser($request);

    public function store($request);

    public function delete($id);

    

}
