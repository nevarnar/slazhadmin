<?php

namespace App\Http\Requests\API\Product;

use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\API\APIRequest;


class ProductCreateOrUpdateRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        // $id = $this->request->get('id');
        return [
            'data.*.name' => 'required',
            // 'photo' => 'sometimes|image|mimes:png,jpg,gif,webp,PNG,JPG|max:4096',
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
