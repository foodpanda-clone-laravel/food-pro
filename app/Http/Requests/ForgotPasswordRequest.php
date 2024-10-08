<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'email'=>'required|exists:users,email'
        ];
    }
    public function messages(){
        return [
            'email.required'=>'Email fied is required',
            'email.exists'=>'Invalid email addresss'
        ];
    }
}
