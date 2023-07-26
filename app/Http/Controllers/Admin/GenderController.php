<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Gender\GenderRepositoryInterface;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    //
    private  GenderRepositoryInterface $genderRepository;
    public function __construct(GenderRepositoryInterface $repo)
    {
        $this->genderRepository=$repo;
    }
    public function getGenders(){
        $genders=$this->genderRepository->list();
        responseData('data',$genders,200);
    }

}
 