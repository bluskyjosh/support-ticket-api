<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CommentRequest extends Request
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
                    'comment' => 'required|string'
                ];
                break;
            case 'PUT':
            case 'PATCH':
                $rules = [
                    'comment' => 'required|string'
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
