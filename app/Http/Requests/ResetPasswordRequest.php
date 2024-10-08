<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

            return [
            'token'=>'required', 
            'email'=>'required|exists:users,email',
            'password_confirmation'=>'required',
            'password'=>['required', 'confirmed', Password::min(8),'max:11']
            ];
     
    }
    public function messages(){
        return [
        'token.required'=>'Password reset token is required',
        'email.required'=>"Email field can't be empty",
        'email.exists'=>"Account not found",
        'password.required'=>'Password field is required',
        'password_confirmation.required'=>'password confirmation field is required',
        'password.confirmed'=>"Passwords donot match",
        'password.max'=>"Password length exceeds max length of 11 characters"
        ];
    }
   
}
