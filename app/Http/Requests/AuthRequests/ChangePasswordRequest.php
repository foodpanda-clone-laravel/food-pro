<?php

namespace App\Http\Requests\AuthRequests;


use App\Http\Requests\BaseRequest;

class ChangePasswordRequest extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'old_password'=>'required',
            'new_password'=>'required',
        ];
    }
}
