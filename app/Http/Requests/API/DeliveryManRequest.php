<?php


namespace App\Http\Requests\API;
use App\Http\Requests\API\APIRequest;
use Illuminate\Contracts\Validation\Validator;

class DeliveryManRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        $id = $this->request->get('id');
        return [
            'data*.name' => 'required|string',
            'phone_number' => 'required|unique:delivery_men,phone_number,'.$id,
            'delivery_id' => 'required',
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
