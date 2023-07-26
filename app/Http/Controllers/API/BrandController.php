<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Brand\BrandRepositoryInterface;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    private BrandRepositoryInterface $brandRepository;

    public function __construct(BrandRepositoryInterface $repo)
    {
        $this->brandRepository = $repo;
    }

    public function getBrands(){
        $brands =  $this->brandRepository->getBrands();
        responseData('brands',$brands,200);
    }
}
