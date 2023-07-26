<?php

namespace App\Http\Repositories\SubCategory;

use App\Models\SubCategory;

interface SubCategoryRepositoryInterface{

    public function list($request);

    public function availableList($request);

    public function createOrUpdate($request);

    public function delete(SubCategory $sub_category);

    public function details(SubCategory $sub_category);

    public function getSubCategoryByCategory($request);
}
