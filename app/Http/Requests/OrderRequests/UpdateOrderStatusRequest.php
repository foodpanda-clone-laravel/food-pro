<?php

namespace App\Http\Requests\OrderRequests;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'order_id' => 'required|integer|exists:orders,id',
            'status' => 'required|in:confirm,cancel',
        ];
    }

    public function messages()
    {
        return [
            'order_id.required' => 'Order ID is required.',
            'order_id.integer' => 'Order ID must be an integer.',
            'order_id.exists' => 'Order ID does not exist.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either "confirm" or "cancel".',
        ];
    }
}
