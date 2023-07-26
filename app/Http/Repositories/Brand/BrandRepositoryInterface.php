<?php

namespace App\Http\Repositories\Brand;

use App\Models\Brand;

interface BrandRepositoryInterface {

    public function list($request);

    public function availableList($request);

    public function createOrUpdate($request);

    public function delete(Brand $brand);

    public function details(Brand $brand);

    public function getBrands();


}
