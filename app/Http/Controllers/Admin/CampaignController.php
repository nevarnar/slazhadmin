<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Repositories\Campaign\CampaignInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Models\Campaign;

class CampaignController extends Controller
{
    //
    private $campaignRepository;

    public function __construct(CampaignInterface $repo)
    {
        $this->campaignRepository=$repo;
    }

    public function index(Request $request){
        $campaign_items=$this->campaignRepository->list($request);
        (new ResponsePaginatedApiData($campaign_items, $request));
    }

    public function show(Campaign $campaign){
        $campaign_item=$this->campaignRepository->details($campaign);
        responseData('data',$campaign_item,200);
    }

    public function createOrUpdate(Request $request){
        (new UniqueCheck())->run($request,'campaign');
        $created_campaign_item=$this->campaignRepository->createOrUpdate($request);
        responseData('data',$created_campaign_item,200);
    }
    public function destroy(Campaign $campaign){
        ($this->campaignRepository->delete($campaign)) ?
         responseTrue('Campaign Delete Successfully ') : responseFalse();
    }
}
