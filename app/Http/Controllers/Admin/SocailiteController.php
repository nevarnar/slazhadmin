<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocailiteController extends Controller
{
    //
     #google login
     public function loginGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function delete(){
        responseTrue('successfully deleted');
    }

    public function callbackGoogle(){
        try{
            $google_user=Socialite::driver('google')->user();
            $user=User::where('email',$google_user->email)->first();
            if($user){
                Auth::login($user);
                return redirect('/');
            }else{
                $createUser = User::create([
                    'email' => $google_user->email,
                    'google_id'=>$google_user->id,
                ]);
                Auth::login($createUser);
                return redirect('/');
            }
            return redirect('register');
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }
    #google login


    #facebook login
    public function loginFacebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callbackFacebook(){
        try{
            $facebook_user=Socialite::driver('facebook')->user();
            $user=User::where('facebook_id',$facebook_user->id)->first();
            if($user){
                Auth::login($user);
                return redirect('/');
            }else{
                $createUser = User::create([
                    'email' => $facebook_user->email,
                    'facebook_id' => $facebook_user->id,
                ]);
                Auth::login($createUser);
                return redirect('/');
            }
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }

    #end facebook login
}
