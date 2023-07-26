<?php

namespace App\Http\Requests;

use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends APIRequest
{
    public function rules()
    {
        return [
            'user_name' => 'required',
            // bail|required|string|exists:users,username
            'password'=>'required',
        ];
    }
    public function authorize()
    {
        return parent::authorize();
    }
 
    public function failedValidation(Validator $validator)
    {
        parent::failedValidation($validator);
    }
    public function getCredentials()
    {
       
        return [
                'user_name' =>  strtolower($this->get('user_name')),
                'password' => $this->get('password'),
         ];

    }
}
