<?php

namespace App\Http\Requests\API\Supplier;

use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class SupplierCreateOrUpdateRequest extends APIRequest{

    public function rules()
    {
        $id = $this->request->get('id');
        return [
            'data' => 'required',
            'sku_name' => 'required|unique:suppliers,sku_name,'.$id,
            'contact_name' => 'required',
            'phone_number' => 'required|unique:suppliers,phone_number,'.$id,
            'address' => 'required',
            'country_id' => 'required',
            'brand_ids' => 'required'
        ];
    }

    public function authorize(){
        return parent::authorize();
    }

    public function failedValidation(Validator $validator){
        parent::failedValidation($validator);
    }
}
