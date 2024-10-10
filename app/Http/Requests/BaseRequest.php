<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class BaseRequest extends FormRequest
{
    
// override failed validation once in base class
    protected function failedValidation(Validator $validator)
    {
        $errors = $this->validator->errors();

        $response =  response()->json([
            'errors'=>$errors
        ], 400);
        throw new HttpResponseException($response);
    }
    public function getValidatedData(){
        return $this->validated();
    }
}
