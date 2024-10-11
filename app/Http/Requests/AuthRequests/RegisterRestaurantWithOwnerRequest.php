<?php

namespace App\Http\Requests\AuthRequests;

use App\Http\Requests\BaseRequest;

class RegisterRestaurantWithOwnerRequest extends BaseRequest
{


    public function rules()
    {
        return [
            // Owner information
            'cnic' => 'required|string|digits:13|unique:restaurant_owners,cnic',
            'bank_name' => 'required|string|max:255',
            'restaurant_name' => 'required|string|max:255|unique:restaurants,name',
            'iban' => 'required|string|max:34',
            'account_owner_title' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password'=>'required|string|min:8',
            'password_confirmation' => 'required|string|same:password',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'opening_time' => 'nullable|date_format:H:i',
            'closing_time' => 'nullable|date_format:H:i',
            'cuisine' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            // implement validation logic for business type from database enum values
            'logo_path' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
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
