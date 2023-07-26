<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\AdminType;
use App\Models\Department;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\API\Admin\ChangePasswordRequest;
use App\Http\Repositories\Admin\AdminRepositoryInterface;
use App\Http\Actions\ResponseData\ResponsePaginatedApiData;
use App\Http\Requests\API\Admin\AdminCreateOrUpdateRequest;

class AdminController extends Controller
{
    private $adminRepository;
    public function __construct(AdminRepositoryInterface $repo)
    {
        $this->adminRepository=$repo;
    }
    public function index(Request $request)
    {
        $admins=$this->adminRepository->list($request);
        (new ResponsePaginatedApiData($admins, $request));
    }

    // public function list(){
    //     return $this->adminRepository->list();
    // }

    /**
     * Show the form for creating a new resource.
     *?
     * @return \Illuminate\Http\Response
     */
    public function createOrUpdate(AdminCreateOrUpdateRequest $request)
    {
        $admin=$this->adminRepository->createOrUpdate($request);
        // dd($admin);
        responseData('data', $admin, 200);
    }

    public function show(Admin $admin){
        $admin = $this->adminRepository->detail($admin);
        responseData('data', $admin, 200);
    }

    public function changePassword(ChangePasswordRequest $request){
        ($this->adminRepository->changePassword($request))? responseTrue('Password updated successfully '):responseFalse();

    }

    public function getDepartmentList(){
        return Department::orderBy('id','desc')->get();
    }
    public function getAdminType(){
        responseData('data',AdminType::select('id','name')->get(),200);
    }
    public function getPermission(){
        responseData('data',Permission::select('id','name','slug')->get(),200);
    }
    public function destroy(Admin $admin){
        ($this->adminRepository->delete($admin))? responseTrue('Deleted successfully '):responseFalse();
    }


}
