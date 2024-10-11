<?php

namespace App\Http\Requests\Customer;
use App\Http\Requests\BaseRequest;

use Illuminate\Foundation\Http\FormRequest;

class AddFavoriteRestaurantRequest extends BaseRequest
{

    public function rules()
    {
        return [
            'restaurant_id' => 'required|exists:restaurants,id'
        ];
    }
}
