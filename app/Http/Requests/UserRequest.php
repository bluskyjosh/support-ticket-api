<?php

namespace App\Http\Requests;



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
        return [
            //
        ];
    }
}
