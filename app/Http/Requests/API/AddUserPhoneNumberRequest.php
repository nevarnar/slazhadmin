<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;

class AddUserPhoneNumberRequest extends APIRequest
{
    public function rules()
    {
        return [
            'new_phone_number' => 'bail|required|unique:users,phone_number',
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
