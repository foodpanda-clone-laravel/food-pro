<?php

namespace App\Http\Requests\CustomerRequests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class UsePointsRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'points' => 'required|integer|min:1',
        ];
    }
}