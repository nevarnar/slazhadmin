<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Actions\ResponseData\ResponseApiData;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Requests\API\Category\CategoryCreateOrUpdateRequest;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $repo)
    {
        $this->categoryRepository = $repo;
    }

    public function getAllCategories(Request $request)
    {
        $route_name=Route::currentRouteName();
        $categories = $this->categoryRepository->list($request);
        if($route_name==='category.all'){

            responseData('data',$categories,200);
        }
        (new ResponsePaginatedApiData($categories, $request));
    }

    public function getCategories(Request $request){
        $type=Route::currentRouteName();
        $categories = $this->categoryRepository->listWithType($request,$type);
        responseData('data',$categories,200);
    }

    public function getCategory(Category $category){
        $category = $this->categoryRepository->details($category);
        responseData('data', $category, 200);
    }

    public function createOrUpdate(CategoryCreateOrUpdateRequest $request){
        // (new UniqueCheck())->run($request,'category');
        $category = $this->categoryRepository->createOrUpdate($request);
        responseData('data', $category, 200);
    }

    public function changeCategoryIsAvailable(Request $request){
        $model= Category::find($request->id);
        if ($model) {
            $model->is_available = $request->is_available;
            $model->save();
            responseStatus('Available update successfully', 200);
        }
        responseStatus("Available can't update for this product,Pls try again", 200);
    }

    public function deleteCategory(Category $category){
        ($this->categoryRepository->delete($category)) ? responseTrue('deleted successfully') :responseFalse();
    }



    //dont delete for nps test
    public function test(Request $request){
        dd($request->all());
            // foreach ($request->file('gallery') as $file) {
            //     $name = $file->getClientOriginalName();
            //    dd($name);
            // }
    }
}
