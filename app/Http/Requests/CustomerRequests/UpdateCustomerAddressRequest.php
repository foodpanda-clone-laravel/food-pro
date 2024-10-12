<?php

namespace App\Http\Requests\CustomerRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class UpdateCustomerAddressRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'address' => 'sometimes|string|min:5',
            'delivery_address' => 'sometimes|nullable|string|min:5',
        ];
    }
}