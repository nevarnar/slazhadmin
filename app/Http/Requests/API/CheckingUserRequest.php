<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;

class CheckingUserRequest extends APIRequest
{

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id',
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
