<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Size\SizeRepositoryInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

class SizeController extends Controller
{
    private $sizeRepository;
    public function __construct(SizeRepositoryInterface $repo)
    {
        $this->sizeRepository=$repo;
    }

    public function index(Request $request){
        $sizes=$this->sizeRepository->list($request);
        (new ResponsePaginatedApiData($sizes, $request));
    }

    public function show(Size $size){
        $size = $this->sizeRepository->details($size);
        responseData('data', $size, 200);
    }

    public function createOrUpdate(Request $request){
        $size = $this->sizeRepository->createOrUpdate($request);
        responseData('data', $size, 200);
    }

    public function getSizes(Request $request){
        $sizes=$this->sizeRepository->list($request);
        responseData('data',$sizes,200);
    }

    public function addSize(Request $request){
        Size::create([
            'name'=>$request->name,
            'unit_type_id'=>2,
        ]);
        responseStatus('Size add successfully',200);
    }
}
