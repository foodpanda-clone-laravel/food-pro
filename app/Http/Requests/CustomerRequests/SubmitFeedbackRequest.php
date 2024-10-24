<?php

namespace App\Http\Requests\CustomerRequests;

use App\Http\Requests\BaseRequest;

class SubmitFeedbackRequest extends BaseRequest
{
    public function rules()
    {
        return [
             'order_id' => 'required|exists:orders,id',
             'rating' => 'required|min:1|max:5',
             'review' => 'nullable|string',
        ];
    }
}
