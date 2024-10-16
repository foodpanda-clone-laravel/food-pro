<?php
namespace App\Http\Requests;
use App\Http\Requests\BaseRequest;
use App\Rules\ValidateTimeRule;
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
            'restaurant_name' => 'nullable|string|min:5',
            'opening_time' => 'nullable|',
            'closing_time' => 'nullable|',
            'logo_path' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'address' => 'nullable|string|max:255'
        ];
    }
}
