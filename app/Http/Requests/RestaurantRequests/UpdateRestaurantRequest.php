<?php
namespace App\Http\Requests\RestaurantRequests;
use App\Http\Requests\BaseRequest;

class UpdateRestaurantRequest extends BaseRequest
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
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
            'city' => 'nullable|string|max:100',
            'opening_time' => 'nullable|date_format:H:i:s',
            'closing_time' => 'nullable|date_format:H:i:s|after:opening_time',
            'business_type' => 'nullable|string|max:50',
            'cnic' => 'nullable|string|size:13|unique:restaurant_requests,cnic',
            'bank_name' => 'nullable|string|max:100',
            'iban' => 'nullable|string|max:34|unique:restaurant_requests,iban',
            'account_owner_title' => 'nullable|string|max:255',
            'cuisine' => 'nullable|string|max:100',
            'phone_number' => 'nullable',
            'restaurant_name' => 'nullable|string|max:255',
            'logo_path'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
