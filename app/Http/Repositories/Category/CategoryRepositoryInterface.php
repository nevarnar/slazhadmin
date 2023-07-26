<?php

namespace App\Http\Repositories\Category;

use App\Models\Category;

interface CategoryRepositoryInterface{

    public function list($request);

    public function createOrUpdate($request);

    public function delete(Category $category);

    public function details(Category $category);

    public function listWithType($request,$type);

    public function getCategoriesByGender($gender_id);

}
