<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;


class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch ($this->method()){
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                return $this->isAdmin();
            case 'POST':
            case 'GET':
                return true;
            default:
                return false;

        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        switch ($this->method()){
            case 'POST':
                $rules = [
                    'name' => 'required|string|max:191',
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('users')
                    ],
                    'password' => 'string|min:8|max:191'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'name' => 'string|max:191',
                    'email' => [
                        'email',
                        Rule::unique('users')
                    ],
                    'password' => 'string|min:8|max:191'
                ];
                break;
            case 'DELETE':
            case 'GET':
            default:
                break;
        }

        return $rules;
    }
}
