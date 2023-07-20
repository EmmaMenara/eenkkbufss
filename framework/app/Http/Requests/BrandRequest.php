<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'PUT')
        {
            // Update operation, exclude the record with id from the validation:
            $name_rule = 'required|unique:brand,name,' . $this->get('id');
        }
        else
        {
            // Create operation. There is no id yet.
            $name_rule = 'required|unique:brand,name';
        }
        return [
            'name' => $name_rule,
        ];

        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->toArray()
            ]);
        }
        return response()->json([
            'success' => true
        ]);

    }
}
