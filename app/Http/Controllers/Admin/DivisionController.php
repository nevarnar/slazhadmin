<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Division\DivisionInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

class DivisionController extends Controller
{
    //
    private $divisionRepository;

    public function __construct(DivisionInterface $repo)
    {
        $this->divisionRepository=$repo;
    }

    public function index(Request $request){
        $division=$this->divisionRepository->list($request);
        (new ResponsePaginatedApiData($division, $request));
    }
    public function getDivisions(Request $request){
        $division=$this->divisionRepository->list($request);
        responseData('data',$division,200);
    }
}
