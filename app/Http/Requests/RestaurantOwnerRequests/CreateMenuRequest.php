<?php

namespace App\Http\Requests\RestaurantOwnerRequests;

use App\Http\Requests\BaseRequest;

class CreateMenuRequest extends BaseRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The menu name is required.',
            'name.string' => 'The menu name must be a valid string.',
            'name.max' => 'The menu name cannot exceed 255 characters.',
            'description.string' => 'The description must be a valid string.',
            'description.required' => 'The description is required.',
            'description.max' => 'The description cannot exceed 1000 characters.',
        ];
    }


}
