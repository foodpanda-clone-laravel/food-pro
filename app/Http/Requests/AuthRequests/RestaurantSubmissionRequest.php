<?php

namespace App\Http\Requests\AuthRequests;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class RestaurantSubmissionRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:restaurant_requests,email',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'city' => 'required|string|max:100',
            'opening_time' => 'required|date_format:H:i:s',
            'closing_time' => 'required|date_format:H:i:s|after:opening_time',
            'business_type' => 'required|string|max:50',
            'cnic' => 'required|string|size:13|unique:restaurant_requests,cnic',
            'bank_name' => 'required|string|max:100',
            'iban' => 'required|string|max:34|unique:restaurant_requests,iban',
            'account_owner_title' => 'required|string|max:255',
            'cuisine' => 'required|string|max:100',
            'restaurant_name' => 'required|string|max:255',
            'logo_path' => 'required|mimes:jpeg,jpg,png', // Adjust if using file upload validation
        ];
    }
}
