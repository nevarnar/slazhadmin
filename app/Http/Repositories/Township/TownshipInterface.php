<?php

namespace App\Http\Repositories\Township;

interface TownshipInterface
{
    public function list($request);

    public function createOrUpdate($request);

    public function update($request);

    public function details($township);

    public function getTownships($request);

    public function delete($township);
    public function getDivisions($request);
    public function getTownshipByDivision($division_id);
}
