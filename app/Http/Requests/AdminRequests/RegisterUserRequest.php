<?php

namespace App\Http\Requests\AdminRequests;

use App\Http\Requests\BaseRequest;

class RegisterUserRequest extends BaseRequest
{
    public function authorize()
    {
        return true; // Allow all users to make this request
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',  
            'password' => 'required|string|min:8|confirmed', 
          
        ];
    }

    // Custom messages for validation errors
    public function messages()
    {
        return [
            'email.unique' => 'This email is already registered. Please log in or use another email.', // Custom error message
        ];
    }
}
