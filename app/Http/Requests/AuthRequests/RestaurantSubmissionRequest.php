<?php

namespace App\Http\Requests\AuthRequests;

use App\Http\Requests\BaseRequest;
use App\Rules\ValidateTimeRule;
use Illuminate\Foundation\Http\FormRequest;

class RestaurantSubmissionRequest extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'cnic' => 'required|string|digits:13|unique:restaurant_requests,cnic',
            'bank_name' => 'required|string|max:255',
            'restaurant_name' => 'required|string|max:255|unique:restaurant_requests,restaurant_name',
            'iban' => 'required|string|max:34',
            'account_owner_title' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:restaurant_requests,email',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'opening_time' => ['required', new ValidateTimeRule()],
            'closing_time' => ['required', new ValidateTimeRule()],
            'cuisine' => 'required|string|max:255',
            'business_type' => 'required|string|max:255',
            'logo_path' => 'image|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }
}
