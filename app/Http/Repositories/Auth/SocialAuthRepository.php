<?php

namespace App\Http\Repositories\Auth;

use App\Http\Services\User\UserFacade;
use App\Models\SocialAuth;

class SocialAuthRepository implements SocialAuthInterface
{
    private $data;
    public function create($data){
        $this->data = json_decode(json_encode($data), true);
        $this->data['is_verified'] = 1;
        $user  = ($this->data['email'] == null) ? $this->createUserWithoutEmail() : $this->createUserWithEmail();
        return UserFacade::setUserToken($user);
    }

    protected function createUserWithoutEmail()
    {
        $social_id = SocialAuth::where([['social_id', $this->data['social_id']], ['social_driver', $this->data['social_driver']]])->pluck('user_id')->first();
        if ($social_id) {
            $user = UserFacade::findUser([['id', $social_id]]);
            $user->update($this->data);
        } else {
            $user = UserFacade::create($this->data);
            $this->createSocialAuth($this->data,$user);
        }
        return $user;
    }

    protected function createUserWithEmail()
    {
        $user = UserFacade::findUser([['email', $this->data['email']]]);
        if (!$user) {
            $user = UserFacade::create($this->data);
            $this->createSocialAuth($this->data,$user);
        } else {
            $user->update($this->data);
            $auth_user = SocialAuth::where([['user_id', $user->id], ['social_driver', $this->data['social_driver']]])->first();
            if (!$auth_user) {
                $this->createSocialAuth($this->data,$user);
            }
        }
        return $user;
    }

    protected function createSocialAuth($data, $user){
        SocialAuth::create([
            'social_id' => $data['social_id'],
            'social_driver' => $data['social_driver'],
            'user_id' => $user->id
        ]);
    }
}
