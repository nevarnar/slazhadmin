<?php

namespace App\Http\Requests\API\Defect;

use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;


class DefectCreateRequest extends APIRequest
{
    public function rules()
    {
        return [
            'sub_product_id'=>'required',
            'floor_id'=>'required',
            'quantity'=>'required',
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
