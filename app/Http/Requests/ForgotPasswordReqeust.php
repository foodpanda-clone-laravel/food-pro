<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordReqeust extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'email'=>'required|exists:users,email'
        ];
    }
    public function messages(){
        return [
            'email.required'=>'Email field is required',
            'email.exists'=>'Invalid email'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $this->validator->errors();

        $response =  response()->json([
            'errors'=>$errors
        ], 400);
        throw new HttpResponseException($response);
    }
}
