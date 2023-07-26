<?php

namespace App\Http\Requests\API;

use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class ReviewRequestValidate extends APIRequest
{
      /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'comment' => 'required',
            'product_id'=>'exists:App\Models\Product,id',
            'user_id'=>'exists:users,id',
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
