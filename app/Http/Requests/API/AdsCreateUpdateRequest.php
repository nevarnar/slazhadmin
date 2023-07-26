<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class AdsCreateUpdateRequest extends APIRequest
{
    public function rules()
    {
        return [
            'link' => ['nullable','regex:/\b(?:(?:https ?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i'],
            'photo' => 'sometimes|image|mimes:png,jpg,webp,PNG,JPG|max:5120',
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
