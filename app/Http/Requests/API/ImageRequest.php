<?php

namespace App\Http\Requests\API;


use Illuminate\Contracts\Validation\Validator;

class ImageRequest extends APIRequest
{

    public function rules()
    {
        return [
            'image' =>'required|image|mimes:png,jpg,webp,PNG,JPG|max:5120',
        ];
    }

    public function authorize(){
        return parent::authorize();
    }

    public function failedValidation(Validator $validator){
        parent::failedValidation($validator);
    }
}
