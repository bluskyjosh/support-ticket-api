<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => [
                'required',
                'string',
                'min:8'
            ]
        ];
    }
}
