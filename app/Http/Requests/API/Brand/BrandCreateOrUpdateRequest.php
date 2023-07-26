<?php

namespace App\Http\Requests\API\Brand;

use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class BrandCreateOrUpdateRequest extends APIRequest{

    public function rules()
    {
        $id = $this->request->get('id');
        return [
            'data' => 'required',
            'sku_name' => 'required|unique:brands,sku_name,'.$id,
            'logo' => 'sometimes|image|mimes:png,jpg,gif,webp,jpeg,PNG,JPG',
            'photo' => 'sometimes|image|mimes:png,gif,jpeg,jpg,gif,webp,PNG,JPG',
            'country_id' => 'required'
        ];
    }

    public function authorize()
    {
        return parent::authorize();
    }

   
}
