<?php

namespace App\Http\Repositories\Defect;

interface DefectRepositoryInterface
{
    public function list($request);

    public function create($request);

    public function delete($defect);

    public function updateStatus($request);
}
