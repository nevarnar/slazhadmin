<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Repositories\Address\AddressInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

class AddressController extends Controller
{
    //
    private AddressInterface $addressRepository;

    public function __construct(AddressInterface $repo)
    {
        $this->addressRepository = $repo;
    }
    public function listByUser(Request $request){
        $addresses=$this->addressRepository->listByUser($request);
        responseData('data',$addresses,200);
    }

    public function store(Request $request){
        $address=$this->addressRepository->store($request);
        responseData('data',$address,200);
    }
    public function delete($id){
        ($this->addressRepository->delete($id));
    }

}
