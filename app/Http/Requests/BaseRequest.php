<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class BaseRequest extends FormRequest
{

    public function authorize(){
        return true;
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $this->validator->errors()->all();

        $response =  response()->json([
            'errors'=>$errors
        ], 400);
        throw new HttpResponseException($response);
    }

}
