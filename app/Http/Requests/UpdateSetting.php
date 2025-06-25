<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSetting extends FormRequest
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
            'exit_time'   => 'required',
            'family_tax'  => 'required',
            'family_ent'  => 'required',
            'rev_tax'     => 'required',
            'rev_ent'     => 'required',
            'address'     => 'required',
            'title'       => 'required',
            'terms'       => 'required',
            'logo'        => 'nullable',
            'about'       => 'required',
            'facebook'    => 'url|nullable',
            'twitter'     => 'url|nullable',
            'instagram'   => 'url|nullable',
            'snap'        => 'url|nullable',
        ];
    }
    public function messages(){
        return[
            'exit_time.required'   => 'Enter The Default Exit Time',
            'family_tax.required'  => 'Enter The Tax Of The Family Tickets',
            'rev_tax.required'     => 'Enter The Tax Of The Reservations',
            'address.required'     => 'Enter The Address Of The Park',
            'logo.nullable'        => 'The Logo Is Required',
            'title.required'       => 'The Title Is Required',
            'terms.required'       => 'Enter The Terms Of The Park',
            'about.required'       => 'Enter The Main Info About The Park',
            'facebook.url'         => 'Enter A Valid Facebook URL Link Start With https://',
            'twitter.url'          => 'Enter A Valid URL twitter Link Start With https://',
            'instagram.url'        => 'Enter A Valid URL Instagram Link Start With https://',
            'snap.url'             => 'Enter A Valid URL SnapChat Link Start With https://',
        ];
    }
}
