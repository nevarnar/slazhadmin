<?php

namespace App\Http\Requests\API\SubCategory;

use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class SubCategoryCreateOrUpdateRequest extends APIRequest{

    public function rules()
    {
        $id = $this->request->get('id');
        return [
            'data' => 'required',
            'sku_name' => 'required|unique:sub_categories,sku_name,'.$id,
            'category_id' => 'required',
            // 'icon' => 'sometimes|image|mimes:png,jpg,webp,PNG,JPG|max:5120',
            'measurement_ids' => 'required',
            'unit_type_id' => 'required',
            'unit_id' => 'sometimes'
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
