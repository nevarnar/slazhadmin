<?php

namespace App\Http\Requests\API\Occasion;

use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class OccasionCreateOrUpdateRequest extends APIRequest {

    public function rules()
    {
        return [
            // 'icon' => 'sometimes|image|mimes:png,jpg,webp,PNG,JPG|max:5120'
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
