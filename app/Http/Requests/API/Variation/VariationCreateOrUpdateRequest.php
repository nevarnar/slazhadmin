<?php

namespace App\Http\Requests\API\Variation;

use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class VariationCreateOrUpdateRequest extends APIRequest
{
    public function rules()
    {
        return [
            'data' => 'required',
            'sub_variations' => 'required',
            'sub_category_ids' => 'required'
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
