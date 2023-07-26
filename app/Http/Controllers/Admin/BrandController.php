<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

use App\Models\Brand;
use App\Http\Repositories\Brand\BrandRepositoryInterface;
use App\Http\Requests\API\Brand\BrandCreateOrUpdateRequest;

class BrandController extends Controller
{
    private BrandRepositoryInterface $brandRepository;

    public function __construct(BrandRepositoryInterface $repo)
    {
        $this->brandRepository = $repo;
    }
    public function getAllBrands(Request $request){
        $brands = $this->brandRepository->list($request);
        (new ResponsePaginatedApiData($brands, $request));
    }
    public function getBrands(Request $request){
        $brands = $this->brandRepository->availableList($request);
        responseData('data',$brands,200);
    }
    public function getBrand(Brand $brand){
        $brand = $this->brandRepository->details($brand);
        responseData('data', $brand, 200);
    }
    public function createOrUpdate(BrandCreateOrUpdateRequest $request){
        (new UniqueCheck())->run($request,'brand');
        $brand = $this->brandRepository->createOrUpdate($request);
        responseData('data', $brand, 200);
    }

    public function changeBrandIsAvailable(Request $request){
        $model= Brand::find($request->id);
        if ($model) {
            $model->is_available = $request->is_available;
            $model->save();
            responseStatus('Available update successfully', 200);
        }
        responseStatus("Available can't update for this product,Pls try again", 200);
    }

    public function deleteBrand(Brand $brand){
        ($this->brandRepository->delete($brand))? responseTrue('successfully deleted'):responseFalse();
    }
}
