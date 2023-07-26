<?php

namespace App\Http\Repositories\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\DB;

class AdminRepository implements AdminRepositoryInterface
{
    private array $select_data = ['id', 'user_name', 'full_name', 'phone_number', 'email', 'password', 'admin_type_id'];

    function list($request) {
        $admins = Admin::with('admin_type')->select($this->select_data);
        if ($request->search_input != null || $request->search_input != "") {
            $admins->where('full_name', 'LIKE', '%' . $request->search_input . '%')
                ->orWhere('user_name', 'LIKE', '%' . $request->search_input . '%');
        }
        // if($request->department_id!=null || $request->department_id!=""){
        //     $admins->where('department_id',$request->department_id);
        // }
        return $admins->get();
    }

    public function createOrUpdate($request)
    {
        DB::beginTransaction();
        try {
            $permission_ids = json_decode($request->permission_ids);
            $permissions = count($permission_ids) > 0 ? JsonDecode($request->permission_ids) : [];
            $data = $request->all();
            if (!isset($request->id)) {
                $data['id'] = null;
            }
            $admin = Admin::updateOrCreate(
                ['id' => $data['id']],
                $data
            );
            $admin->permissions()->sync($permissions);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            responseStatus($e->getMessage(), 402);
            throw $e;
        }
        return $this->detail($admin);
    }

    public function detail(Admin $admin)
    {
        $admin->permissions = $admin->permissions;
        $admin->admin_type = $admin->admin_type;
        $admin->inventory = $admin->inventory;
        return $admin;
    }

    public function changePassword($request)
    {
        $admin = Admin::find($request->id);
        $admin->fill([
            'password' => $request->new_password,
        ])->save();
        return $admin;
    }

    public function delete(Admin $admin)
    {
        return $admin->delete();
    }
}
