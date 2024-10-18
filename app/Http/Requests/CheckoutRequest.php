<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'delivery_details'=>'required|string',
        ];
    }
}
