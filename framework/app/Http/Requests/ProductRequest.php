<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        if ($this->method() == 'PUT') {
            return [
                'codebar' => 'required',
                'codeinner' => 'required',
                'brand_id' => 'required',
                'price' => 'required',
                'name' => 'required',
                'stockmin' => 'required',
                'stockmax' => 'required',
            ];
        } else {
            return [
                'codebar' => 'required',
                'codeinner' => 'required',
                'brand_id' => 'required',
                'price' => 'required',
                'name' => 'required',
                'stockmin' => 'required',
                'stockmax' => 'required',
             //   'photo' => 'required|mimes:jpeg,png|max:2400',
            ];
        }
    }
}
