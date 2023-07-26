<?php

namespace App\Http\Repositories\Series;

use App\Models\Series;

interface SeriesRepositoryInterface
{
    public function list($request);
    
    public function createOrUpdate($request);


    public function details(Series $series);

    public function listWithType($request,$type);

    public function getProductSeries($request);

}
