<?php

namespace App\Http\Requests;
use App\Http\Requests\BaseRequest;


use App\Rules\ValidateTimeRule;

class UpdateApplicationRequest extends BaseRequest
{

    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        return [
                    // Owner information
        'cnic' => 'nullable|string|digits:13|unique:restaurant_owners,cnic,',
        'bank_name' => 'nullable|string|max:255',
        'restaurant_name' => 'nullable|string|max:255|unique:restaurants,name,' ,
        'iban' => 'nullable|string|max:34',
        'account_owner_title' => 'nullable|string|max:255',
        'first_name' => 'nullable|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'email' => 'nullable|string|email|max:255|unique:users,email,',
        'password' => 'nullable|string|min:8',
        'password_confirmation' => 'nullable|string|same:password',
        'address' => 'nullable|string|max:255',
        'postal_code' => 'nullable|string|max:20',
        'city' => 'nullable|string|max:255',
        'opening_time' => ['nullable', new ValidateTimeRule()],
        'closing_time' => ['nullable', new ValidateTimeRule()],
        'cuisine' => 'nullable|string|max:255',
        'business_type' => 'nullable|string|max:255|in:Restaurant,Cafe,Bar', // Enum check from valid types
        'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }
}
