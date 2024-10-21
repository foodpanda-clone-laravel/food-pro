<?php

namespace App\Http\Requests\RestaurantRequests;

use App\Http\Requests\BaseRequest;

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
//            'id'=>'required|exists:restaurants,id'
        ];
    }
}
