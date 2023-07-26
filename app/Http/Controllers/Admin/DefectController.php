<?php

namespace App\Http\Controllers\Admin;

use App\Models\Defect;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\Defect\DefectCreateRequest;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Repositories\Defect\DefectRepositoryInterface;

class DefectController extends Controller
{
    //
    private $defectRepository;
    public function __construct(DefectRepositoryInterface $repo)
    {
        $this->defectRepository=$repo;
    }

    public function index(Request $request){
        $defects = $this->defectRepository->list($request);
        (new ResponsePaginatedApiData($defects, $request));
    }
    public function store(DefectCreateRequest $request){
        $this->defectRepository->create($request);
        responseStatus("Defect created successfully", 200);
    }

    public function updateStatus(Request $request){
        $this->defectRepository->updateStatus($request);
        responseStatus("Defect status updated successfully", 200);
    }

    public function destroy(Defect $defect){
        ($this->defectRepository->delete($defect))? responseTrue('successfully deleted'):responseFalse();
    }


}
