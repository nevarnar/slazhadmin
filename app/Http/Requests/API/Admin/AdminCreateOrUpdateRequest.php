<?php

namespace App\Http\Requests\API\Admin;

use Illuminate\Validation\Rule;
use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class AdminCreateOrUpdateRequest extends APIRequest
{
    public function rules()
    {
        $id = $this->request->get('id');
        return [
            'user_name'=>['required','min:6',Rule::unique('admins')->ignore($id)],
            'full_name'=>'required',
            'phone_number'=>['required',Rule::unique('admins')->ignore($id)],
            'email' => 'nullable|email|unique:admins,email,'.$id,
            'password'=>'required|min:6|confirmed',
            // 'password_confirmation'=>'required|same:password',
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
