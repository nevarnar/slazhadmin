<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Supplier;
use App\Http\Requests\API\Supplier\SupplierCreateOrUpdateRequest;
use App\Http\Repositories\Supplier\SupplierRepositoryInterface;

use App\Http\Actions\UniqueCheck\UniqueCheck;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;

class SupplierController extends Controller
{
    private SupplierRepositoryInterface $supplierRepository;

    public function __construct(SupplierRepositoryInterface $repo)
    {
        $this->supplierRepository = $repo;
    }

    public function getAllSuppliers(Request $request){
        $suppliers = $this->supplierRepository->list($request);
        (new ResponsePaginatedApiData($suppliers, $request));
    }

    public function getSuppliers(Request $request){
        $suppliers = $this->supplierRepository->list($request);
        responseData('data', $suppliers, 200);
    }

    public function getSupplier(Supplier $supplier){
        // $supplier = $this->supplierRepository->details($supplier);
        responseData('data', $this->supplierRepository->details($supplier), 200);
    }

    public function createOrUpdate(SupplierCreateOrUpdateRequest $request){
        (new UniqueCheck())->run($request,'supplier');
        $supplier = $this->supplierRepository->createOrUpdate($request);
        responseData('data', $supplier, 200);
    }

    public function deleteSupplier(Supplier $supplier){
        ($this->supplierRepository->delete($supplier)) ? responseTrue('deleted successfully') :responseFalse();
    }
}
