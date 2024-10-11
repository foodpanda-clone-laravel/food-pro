<?php

namespace App\Http\Requests\CustomerRequests;

use App\Http\Requests\BaseRequest;

class AddFavoriteRestaurantRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'restaurant_id' => 'required|integer|exists:restaurants,id',
        ];
    }
}