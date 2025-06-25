<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShift extends FormRequest
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
        return [
            'from' => 'required|unique:shifts,from,'.$this->id.',id',
            'to'   => 'required|unique:shifts,to,'.$this->id.',id',
        ];
    }
    public function messages(){
        return[
            'from.required' => 'Start Time is Required',
            'from.unique'   => 'The Selected Start Time Exists',
            'to.required'   => 'End Time is Required',
            'to.unique'     => 'The Selected End Time Exists ',
            'to.gt'         => 'The End Time Must Be After Start Time',

        ];
    }
}
