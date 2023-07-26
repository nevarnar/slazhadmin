<?php

namespace App\Http\Repositories\Ads;

use App\Models\Ads;

interface AdsRepositoryInterface
{
    public function list($request);
    
    public function createOrUpdate($request);

    public function delete(Ads $ads);

    public function getAdsType();

    public function details(Ads $ads);
    
    public function getDetails($ads_id);
}
