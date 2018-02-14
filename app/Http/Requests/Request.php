<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function forbiddenResponse()
    {
        return response()->json('User does not have permissions necessary to complete request.', 403);
    }


    public function response(array $errors)
    {
        return response()->json(
            [
                'message' => 'There were some errors in your request:',
                'errors' => $errors,
                'code' => 422
            ], 422);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->response(
            $this->formatErrors($validator)
        ));
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->getMessageBag()->toArray();
    }

    public function isAdmin() {
        return $this->user()->is_admin === true;
    }
}
