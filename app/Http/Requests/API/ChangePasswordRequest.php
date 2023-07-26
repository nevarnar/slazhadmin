<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends APIRequest
{
    public function rules()
    {
        return [
            'user_id'=>'required',
            'password' => 'bail|required|min:6',
            'confirm_password' => 'required|same:password',
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
