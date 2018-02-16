<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Http\Requests\Request;


class TicketRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch ($this->method()){
            case 'GET':
            case 'POST':
            case 'PUT':
            case 'PATCH':
            case 'DELETE':
                return $this->isAdmin();

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
                    'category_id' => 'required|integer',
                    'priority_id' => 'required|integer',
                    'title' => 'required|string|max:191',
                    'description' => 'required|string',
                    'status_id' => 'integer',
                    'created_by_id' => 'integer',
                    'updated_by_id' => 'integer'
                ];
                break;
            case 'PUT':
            case 'PATCH':
            $rules = [
                'category_id' => 'integer',
                'priority_id' => 'integer',
                'title' => 'string|max:191',
                'description' => 'string',
                'status_id' => 'integer',
                'created_by_id' => 'integer',
                'updated_by_id' => 'integer'
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
