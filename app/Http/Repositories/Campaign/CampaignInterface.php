<?php

namespace App\Http\Repositories\Campaign;

interface CampaignInterface
{
    public function list($request);

    public function createOrUpdate($request);

    public function details($campaign);

    public function delete($campaign);
}
