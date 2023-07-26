<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

use App\Models\Color;
use App\Http\Repositories\Color\ColorRepositoryInterface;
use App\Http\Requests\API\Color\ColorCreateOrUpdateRequest;

class ColorController extends Controller
{
    private ColorRepositoryInterface $colorRepository;

    public function __construct(ColorRepositoryInterface $repo)
    {
        $this->colorRepository = $repo;
    }

    public function getAllColors(Request $request){
        $colors = $this->colorRepository->list($request);
        (new ResponsePaginatedApiData($colors, $request));

        responseData('data', $colors, 200);
    }
    public function getColors(Request $request){
        $colors = $this->colorRepository->availableList($request);
        responseData('data', $colors, 200);
    }

    public function getColor(Color $color){
        $color = $this->colorRepository->details($color);
        responseData('data', $color, 200);
    }

    public function createOrUpdate(ColorCreateOrUpdateRequest $request){
        (new UniqueCheck())->run($request,'color');
        $color = $this->colorRepository->createOrUpdate($request);
        responseData('data', $color, 200);
    }
    
    public function changeColorIsAvailable(Request $request){
        $model= Color::find($request->id);
        if ($model) {
            $model->is_available = $request->is_available;
            $model->save();
            responseStatus('Available update successfully', 200);
        }
        responseStatus("Available can't update for this product,Pls try again", 200);
    }

    public function deleteColor(Color $color){
        ($this->colorRepository->delete($color))? responseTrue('successfully deleted'):responseFalse();
    }
}
