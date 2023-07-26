<?php

namespace App\Http\Requests\API\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class ChangePasswordRequest extends APIRequest
{
    public function rules()
    {
        return [
            'old_password' => ['required',
             function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('Current Password didn\'t match');
                }
            },
         ],
            'new_password'=>['required','min:6','confirmed','different:old_password'],
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
}
