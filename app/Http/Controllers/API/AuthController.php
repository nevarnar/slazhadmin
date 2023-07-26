<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Requests\API\CheckingUserRequest;
use App\Http\Requests\API\UserRegisterRequest;
use App\Http\Requests\API\ChangePasswordRequest;
use App\Http\Repositories\Auth\PhoneAuthInterface;
use App\Http\Repositories\Auth\SocialAuthInterface;
use App\Http\Requests\API\AddUserPhoneNumberRequest;

class AuthController extends Controller
{
    private SocialAuthInterface $social_auth;
    private PhoneAuthInterface $phone_auth;

    public function __construct( SocialAuthInterface $socialAuth ,PhoneAuthInterface $phoneAuth){
        $this->social_auth = $socialAuth;
        $this->phone_auth = $phoneAuth;
    }

    public function authWithSocial(Request $request){
        $input_data =  JsonDecode($request->getContent());
        $this->social_auth->create($input_data);
    }

    public function registerWithPhoneNumber(UserRegisterRequest $request){
        $this->phone_auth->sendCodeAndReturnUser($request->all());
    }

    public function loginWithPhoneNumber(Request $request){
        $this->phone_auth->checkPhoneNumberAndPassword($request);
    }

    public function confirmCode(CheckingUserRequest $request){
      return $this->phone_auth->confirmCode($request->user_id, $request->code);
    }

    public function sendCodeByUserId(CheckingUserRequest $request){
        $this->phone_auth->sendCodeByUserId($request->user_id);
    }

    public function forgetPassword(Request $request){
        $this->phone_auth->checkPhoneNumberAndSendCode($request->phone_number);
    }

    public function changePassword(ChangePasswordRequest $request){
        $this->phone_auth->changePassword($request);
    }

    public function addUserPhoneNumber(AddUserPhoneNumberRequest $request){
        $this->phone_auth->addPhoneNumber($request->all());
    }

    public function confirmNewPhoneNumber(Request $request)
    {
        $this->phone_auth->confirmNewPhoneNumber($request->code);
    }
   
}
