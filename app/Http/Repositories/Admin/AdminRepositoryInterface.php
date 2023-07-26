<?php

namespace App\Http\Repositories\Admin;

use App\Models\Admin;

interface AdminRepositoryInterface
{
    public function list($request);

    public function createOrUpdate($request);
    
    public function detail(Admin $admin);
    
    public function delete(Admin $admin);

    public function changePassword($request);

}
