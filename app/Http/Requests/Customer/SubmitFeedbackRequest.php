<?php

namespace App\Http\Requests\Customer;
use App\Http\Requests\BaseRequest;

use Illuminate\Foundation\Http\FormRequest;

class SubmitFeedbackRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string'
        ];
    }
}
