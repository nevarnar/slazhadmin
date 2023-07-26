<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Models\Variation;
use App\Http\Repositories\Variation\VariationRepositoryInterface;
use App\Http\Requests\API\Variation\VariationCreateOrUpdateRequest;

class VariationController extends Controller
{
    private VariationRepositoryInterface $variationRepository;
    
    public function __construct(VariationRepositoryInterface $repo)
    {
        $this->variationRepository = $repo;
    }

    public function getAllVariations(Request $request)
    {
        $variations = $this->variationRepository->list($request);
        (new ResponsePaginatedApiData($variations, $request));
    }

    public function getVariation(Variation $variation)
    {
        $variation = $this->variationRepository->details($variation);
        responseData('data', $variation, 200);
    }

    public function getVarationBySubCategory($id){
        $variation= $this->variationRepository->variationBySubCategory($id);
        responseData('data', $variation, 200);
    }

    public function createVariation(VariationCreateOrUpdateRequest $request)
    {
        (new UniqueCheck())->run($request,'variation');
        $variation = $this->variationRepository->create($request);
        responseData('data', $variation, 200);
    }

    public function updateVariation(Variation $variation, VariationCreateOrUpdateRequest $request)
    {
        (new UniqueCheck())->run($request,'variation');
        $variation = $this->variationRepository->update($variation, $request);
        responseData('data', $variation, 200);
    }

    public function changeVariationIsAvailable(Request $request){
        $model= Variation::find($request->id);
        if ($model) {
            $model->is_available = $request->is_available;
            $model->save();
            responseStatus('Available update successfully', 200);
        }
        responseStatus("Available can't update for this product,Pls try again", 200);
    }

    public function deleteVariation(Variation $variation)
    {
        ($this->variationRepository->delete($variation))? responseTrue('successfully deleted'):responseFalse();
    }
}
