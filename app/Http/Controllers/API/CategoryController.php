<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CategoryController extends Controller
{
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $repo)
    {
        $this->categoryRepository = $repo;
    }

    public function getCategoryByGender(Request $request){
        $categories  =  $this->categoryRepository->getCategoriesByGender($request->gender_id);
        if($request->is_brand == 1){
            $brands = [];
            $en_brand = new \stdClass();
            $en_brand->id = 0;
            $en_brand->name = 'Brand';
            $en_brand->icon = null;
            $en_brand->language_code = 'en';
            $brands [] = $en_brand;
            $mm_brand = new \stdClass();
            $mm_brand->id = 0;
            $mm_brand->name = 'အမှတ်တံဆိပ်';
            $mm_brand->icon = null;
            $mm_brand->language_code = 'mm';
            $brands [] =  $mm_brand;
            $categories = array_merge($brands,$categories);
        }
        responseData('data',$categories,200);
    }


    public function test(){
        $categories = Redis::get('categories');
        if(isset($categories)) {
            $data = JsonDecode($categories);
            responseData('data',$data,200);
        }else {
            $categories =  $this->listQuery()->get();
            Redis::set('categories', $categories);
            responseData('data',$categories,200);
        }
    }




}
