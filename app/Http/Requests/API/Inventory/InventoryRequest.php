<?php

namespace App\Http\Requests\API\Inventory;

use Illuminate\Validation\Rule;
use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class InventoryRequest extends APIRequest
{
    public function rules()
    {
        $id = $this->request->get('id');
        return [
            'sku' => ['required',Rule::unique('inventories')->ignore($id)],
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
