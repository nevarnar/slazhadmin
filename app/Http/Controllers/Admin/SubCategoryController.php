<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

use App\Models\SubCategory;
use App\Http\Requests\API\SubCategory\SubCategoryCreateOrUpdateRequest;
use App\Http\Repositories\SubCategory\SubCategoryRepositoryInterface;

class SubCategoryController extends Controller
{
    private SubCategoryRepositoryInterface $subCategoryRepository;

    public function __construct(SubCategoryRepositoryInterface $repo)
    {
        $this->subCategoryRepository = $repo;
    }

    public function getAllSubCategories(Request $request)
    {
        $sub_categories = $this->subCategoryRepository->list($request);
        (new ResponsePaginatedApiData($sub_categories, $request));
    }
    public function getSubCategories(Request $request)
    {
        $sub_categories = $this->subCategoryRepository->availableList($request);
        responseData('data',$sub_categories,200);
    }

    public function getSubCategory(SubCategory $sub_category)
    {
        $sub_category = $this->subCategoryRepository->details($sub_category);
        responseData('data', $sub_category, 200);
    }

    public function getSubCategoryByCategory(Request $request){
        $sub_categories = $this->subCategoryRepository->getSubCategoryByCategory($request);
        responseData('data', $sub_categories, 200);
    }

    public function createOrUpdate(SubCategoryCreateOrUpdateRequest $request)
    {
        // (new UniqueCheck())->run($request,'sub_category');
        $sub_category = $this->subCategoryRepository->createOrUpdate($request);
        responseData('data', $sub_category, 200);
    }

    public function changeSubCategoryIsAvailable(Request $request){
        // dd($request->all());
        $model= SubCategory::find($request->id);
        if ($model) {
            $model->is_available = $request->is_available;
            $model->save();
            responseStatus('Available update successfully', 200);
        }
        responseStatus("Available can't update for this product,Pls try again", 200);
    }

    public function deleteSubCategory(SubCategory $sub_category, Request $request)
    {
        ($this->subCategoryRepository->delete($sub_category, $request))? responseTrue('successfully deleted'):responseFalse();
    }
}
