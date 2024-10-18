<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ViewRatingsRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id'=>'required|exists:restaurants,id'
        ];
    }
}
