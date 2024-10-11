<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRestaurantWithOwnerRequest extends BaseRequest
{


    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',  
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', 
            'password' => 'required|string|min:8',
            'phone_number'=>'required|string|max:11',
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
            'user_id' => 'required|exists:users,id',
            'email' => 'The Email you have entered is alread exists! Try another Email.',
            'phone_number'=>'Phone Number is required! Enter Phone Number',
            'bank_name'=>'Bank Name is required! Enter Bank Name',
            'iban'=>'iban number is required! Enter Iban number',
            'address'=>'Address is required! Enter your Address',



        ];
    }
}
