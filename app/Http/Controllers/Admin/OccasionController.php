<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

use App\Models\Occasion;
use App\Http\Repositories\Occasion\OccasionRepositoryInterface;
use App\Http\Requests\API\Occasion\OccasionCreateOrUpdateRequest;

class OccasionController extends Controller
{
    private OccasionRepositoryInterface $occasionRepository;

    public function __construct(OccasionRepositoryInterface $repo)
    {
        $this->occasionRepository = $repo;
    }

    public function getAllOccasions(Request $request){
        $occasions = $this->occasionRepository->list($request);
        (new ResponsePaginatedApiData($occasions, $request));
    }
    public function getOccasions(Request $request){
        $occasions = $this->occasionRepository->availableList($request);
        responseData('data', $occasions, 200);
    }

    public function getOccasion(Occasion $occasion){
        $occasion = $this->occasionRepository->details($occasion);
        responseData('data', $occasion, 200);
    }

    public function createOrUpdate(OccasionCreateOrUpdateRequest $request){
        (new UniqueCheck())->run($request,'occasion');
        $occasion = $this->occasionRepository->createOrUpdate($request);
        responseData('data', $occasion, 200);
    }

    public function changeOccasionIsAvailable(Request $request){
        $model= Occasion::find($request->id);
        if ($model) {
            $model->is_available = $request->is_available;
            $model->save();
            responseStatus('Available update successfully', 200);
        }
        responseStatus("Available can't update for this product,Pls try again", 200);
    }

    public function deleteOccasion(Occasion $occasion){
        ($this->occasionRepository->delete($occasion))? responseTrue('successfully deleted'):responseFalse();
    }

}
