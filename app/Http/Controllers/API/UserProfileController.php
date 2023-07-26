<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Repositories\User\UserInterface;
use App\Http\Requests\API\AddUserPhoneNumberRequest;
use App\Http\Requests\API\PasswordRequest;
use App\Http\Requests\API\UserProfileUpdateRequest;


class UserProfileController extends Controller
{
    private UserInterface $userRepoInterface;

    public function __construct(UserInterface $userRepoInterface)
    {
        $this->userRepoInterface = $userRepoInterface;
    }

    public function getProfileDetails()
    {
        $user_profile = $this->userRepoInterface->details();
        responseData('data', $user_profile, 200);
    }

    public function updatePassword(PasswordRequest $request)
    {
        $data = $request->all();
        ($this->userRepoInterface->updatePassword($data)) ?
            responseTrue('User password is successfully updated') :
            responseStatus('Password is incorrect', 401);
    }

    public function updateUserProfile(UserProfileUpdateRequest $request)
    {
        $data = $request->all();
        if (isset($request->image)) {
            $path = UploadImage($request, 'image');
            $data['image_name'] = $path;
        }
        ($this->userRepoInterface->update($data)) ?
            responseTrue('user profile is successfully updated') :
            responseStatus('user profile not successfully updated', 500);
    }



    public function downloadImage($image_name)
    {
        return DownloadImage($image_name);
    }

}
