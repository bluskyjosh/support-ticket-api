<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StatusRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch ($this->method()){
            case 'POST':
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                return $this->isAdmin();
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
                    'description' => 'string|max:191'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'name' => 'string|max:191',
                    'description' => 'string|max:191'
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
