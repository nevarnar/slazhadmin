<?php

namespace App\Http\Requests\API\Transfer;

use Illuminate\Validation\Rule;
use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class TransferCreateRequest extends APIRequest
{
    public function rules()
    {
        return [
            'transfer_id'=>['required',Rule::unique('transfers')],
            'to_inventory_id'=>'required',
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
