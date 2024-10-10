<?php

namespace App\Http\Requests\AuthRequests;

use App\Http\Requests\BaseRequest;

class ForgotPasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'=>'required|exists:users,email|email'
        ];
    }
    public function messages(){
        return [
            'email.required'=>'Email fied is required',
            'email.exists'=>'Invalid email addresss',
            'email.email'=>'Invalid email address format',
        ];
    }
}
