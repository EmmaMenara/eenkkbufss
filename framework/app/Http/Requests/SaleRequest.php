<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
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
//dd("ee",$this->get('customer'));
        if(($this->get('customer'))==99999){
     // dd("SI",$this->all());
            $total= (Integer)$this->get('total');
            //dd($total);
            return [
                'name' => 'required',
                'firts_name' => 'required',
              //  'second_name' => 'required',
                'efectivo'=>'required|Integer|min:'.$total,
            ];
        }else{
         //   dd("NO",$this->all());
            return [
                'customer' => 'required',
                'efectivo'=>'required|Integer|min:'.$this->get('total'),
            ];
        }
    }
}
