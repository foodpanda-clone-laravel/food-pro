<?php

namespace App\Http\Requests\AuthRequests;

use App\Http\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }
}
