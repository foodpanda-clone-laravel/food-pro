<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRestaurantWithOwnerRequest extends BaseRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // Owner information
            'cnic' => 'required|string|max:15|unique:restaurant_owners,cnic',
            'bank_name' => 'required|string|max:255',
            'iban' => 'required|string|max:34',
            'account_owner_title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i',
            'cuisine' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'logo_path' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'cnic.unique' => 'The CNIC is already registered.',
            'user_id.exists' => 'The user must be a valid registered user.',
        ];
    }
}
