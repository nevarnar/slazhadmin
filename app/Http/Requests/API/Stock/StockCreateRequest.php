<?php

namespace App\Http\Requests\API\Stock;

use Illuminate\Validation\Rule;
use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;


class StockCreateRequest extends APIRequest
{
    public function rules()
    {
        $id = $this->request->get('id');
        return [
            'invoice_no' => ['required',Rule::unique('invoices')],
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
