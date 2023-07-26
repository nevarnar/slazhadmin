<?php

namespace App\Http\Requests\API\Coupon;

use Illuminate\Validation\Rule;
use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class CouponCreateRequest extends APIRequest
{
    public function rules()
    {
        $id = $this->request->get('id');

        return [
            'code'=>'required|unique:coupons,code,'.$id,
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
