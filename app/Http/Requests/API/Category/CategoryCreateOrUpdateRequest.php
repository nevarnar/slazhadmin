<?php

namespace App\Http\Requests\API\Category;

use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class CategoryCreateOrUpdateRequest extends APIRequest
{
    public function rules()
    {
        return [
            'data' => 'required',
            // 'icon' => 'sometimes|mimes:jpeg,png,jpg,gif,webp,png,JPG,PNG|max:10000'
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
