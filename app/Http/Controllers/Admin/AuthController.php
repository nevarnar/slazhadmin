<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
    public function login(LoginRequest $request){
        $credentials = $request->getCredentials();
        if(!Auth::validate($credentials))
            return redirect()->route('login')->with('error','Incorrect username or password');
        $admin = Auth::getProvider()->retrieveByCredentials($credentials);
       $auth= Auth::login($admin);
       $admin->device_token=$request->device_token;
       $admin->save();
       if($admin->hasPermission('admin-management')){
        
        return redirect('/admin_users');
       }else if($admin->hasPermission('product-information-management')){
        // return redirect()->route('categories_lists');
        return redirect('categories_lists');
       }
       else if($admin->hasPermission('inventory-management')){
        return redirect('stocks_lists');
       }
       else if($admin->hasPermission('order-management')){
        return redirect('order');
       }
       else if($admin->hasPermission('customer-support-management')){
        return redirect('support_box');
       }
       else{
        return redirect('admin_users');
       }
    //    if($admin->isAdmin()){
    //     $admin->device_token=$request->device_token;
    //     $admin->save();
    //     return redirect('/categories_lists');
    //    }else if($admin->isInventoryManager()){
    //     return redirect()->route('inventory_lists.index');
    //    }else{
    //    }
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
