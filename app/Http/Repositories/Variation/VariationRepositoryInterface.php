<?php

namespace App\Http\Repositories\Variation;

use App\Models\Variation;
use App\Models\SubVariation;

interface VariationRepositoryInterface
{
    public function list($request);

    public function details(Variation $variation);

    public function create($request);

    public function update(Variation $variation, $request);

    public function delete(Variation $variation);

    public function variationBySubCategory($id);
}
