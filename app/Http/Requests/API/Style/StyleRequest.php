<?php

namespace App\Http\Requests\API\Style;
use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;


class StyleRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'data*.name' => 'required|string',
            'item_code'=>'required',
            'photo' => 'sometimes|image|mimes:png,jpg,webp,PNG,JPG|max:5120',
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

    // public function messages()
    // {
    //     return [
    //         'title.required' => 'Please enter a title.',
    //         'price.required' => 'Please enter a price.',
    //         'short_description.required' => 'Please enter a short description.'
    //     ];
    // }
}
