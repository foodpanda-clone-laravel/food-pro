<?php

namespace App\Http\Requests\CartRequests;

use App\Http\Requests\BaseRequest;

class CheckoutRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'delivery_address'=>'required|string',
        ];
    }
}
