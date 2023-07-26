<?php

namespace App\Http\Repositories\Division;

interface DivisionInterface
{
    public function list($request);

    public function delete($division);
}
