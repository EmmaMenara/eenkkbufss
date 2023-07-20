<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
                'name' => 'required',
                'first_surname' => 'required',
              //  'second_surname' => 'required',
            ];
        } else {
            return [
                'name' => 'required',
                'first_surname' => 'required',
               // 'second_surname' => 'required',
            ];
        }
    }
}
