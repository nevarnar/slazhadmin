<?php

namespace App\Http\Requests\API\Color;

use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class ColorCreateOrUpdateRequest extends APIRequest{

    public function rules()
    {
        $id = $this->request->get('id');
        return [
            'data.*.name' => 'required',
            'color_code' => 'required|unique:colors,color_code,'.$id,
            'sku_name' => 'required|unique:colors,sku_name,'.$id,
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
