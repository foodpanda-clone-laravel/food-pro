<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id'=>'required|exists:users,id',
            'restaurant_id'=>'required|exists:restaurants,id',
            'branch_id'=>'exists|branches,id',
            'special_instructions'=>'nullable',
            
        ];
    }
}
