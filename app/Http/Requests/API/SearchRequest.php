<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class SearchRequest extends APIRequest
{
    public function rules()
    {
        return [
            'search_input' => 'sometimes',
            'type' => 'required'
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
