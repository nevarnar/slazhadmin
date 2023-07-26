<?php

namespace App\Http\Repositories\Filter;

interface FilterInterface
{
    public function getFilterData($request);

    public function getFilteredSubProducts($request);

    public function getVariationsByCategoryId($request);
}
