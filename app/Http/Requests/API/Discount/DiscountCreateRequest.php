<?php

namespace App\Http\Requests\API\Discount;

use Illuminate\Validation\Rule;
use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class DiscountCreateRequest extends APIRequest
{
    public function rules()
    {
        $id = $this->request->get('id');
        return [
            'start_time' => ['nullable','date_format:H:i'],
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
