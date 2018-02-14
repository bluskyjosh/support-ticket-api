<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Public request. Just pass through.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules(){
        return [
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => [
                'required',
                'email',
                Rule::unique('users')
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:191'
            ],
            'confirm_password' => [
                'required',
                'string',
                'min:8',
                'max:191'
            ]
        ];
    }
}
