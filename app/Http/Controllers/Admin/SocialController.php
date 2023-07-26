<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Auth\SocialAuthInterface;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialController extends Controller
{
    private $driver;
    private $social_auth;
    public function __construct(SocialAuthInterface $socialAuth){
        $this->social_auth = $socialAuth;
        $route_name = Route::currentRouteName();
        $this->driver = substr($route_name, strpos($route_name, "_") + 1);
    }

    public function redirect(){

        $user = User::all();
        $id = 2;
        $e = 'maythazinkhin53747@gmail.com1';
        foreach ($user as $u){
            if($u->email == $e){
                if ($u->id == $id){
                    return  'same email and same user , pass';
                }
                else{
                   return   'same email , different user, fail';
                }
            }
        }
//        return Socialite::driver($this->driver)
//            ->redirect();
    }

    public function checkUser()
    {
        try {
            $social_user = Socialite::driver($this->driver)->user();
            if ($social_user) {
                $data = [];
                $data['social_token'] = $social_user->token;
                $data['social_id'] = $social_user->getId();
                $data['email'] = $social_user->getEmail();
                $data['name'] = $social_user->getName();
                $data['avatar'] = $social_user->getAvatar() ?: null;
                $data['social_driver'] = $this->driver;
                $user = $this->social_auth->create($data);
                Auth::login($user);
                return redirect('profile');
            }
        } catch (Exception $exception) {
            dd($exception->getMessage());
        }
    }

}
