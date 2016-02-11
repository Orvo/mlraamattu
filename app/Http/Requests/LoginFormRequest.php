<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !\Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'         => 'required',
            'password'      => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'email.required'    => 'Sähköpostiosoite on pakollinen.',
            'email.email'       => 'Annettu sähköpostiosoite ei ole pätevä.',
            'password.required' => 'Salasana on pakollinen.',
        ];
    }
}
