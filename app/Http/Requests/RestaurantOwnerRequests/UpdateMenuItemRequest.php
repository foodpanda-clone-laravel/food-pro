<?php

<<<<<<<< HEAD:app/Http/Requests/RestaurantOwnerRequests/UpdateMenuItemRequest.php
namespace App\Http\Requests\RestaurantOwnerRequests;
========
namespace App\Http\Requests\MenuRequest;
>>>>>>>> main:app/Http/Requests/MenuRequest/UpdateMenuItemRequest.php

use App\Http\Requests\BaseRequest;

class UpdateMenuItemRequest extends BaseRequest
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
            'name' => 'nullable|string|max:255',  // Optional field
            'price' => 'nullable|numeric|min:0',  // Optional field
            'category' => 'nullable|string|max:255',  // Optional field
            'serving_size' => 'nullable|string|max:255',  // Optional field
            'image_path' => 'nullable|string|max:255',  // Optional field
            'discount' => 'nullable|numeric|min:0|max:100',  // Optional field
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
            'name.string' => 'The menu item name must be a valid string.',
            'name.max' => 'The menu item name cannot exceed 255 characters.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',
            'category.string' => 'The category must be a valid string.',
            'category.max' => 'The category cannot exceed 255 characters.',
            'serving_size.string' => 'The serving size must be a valid string.',
            'serving_size.max' => 'The serving size cannot exceed 255 characters.',
            'image_path.string' => 'The image path must be a valid string.',
            'image_path.max' => 'The image path cannot exceed 255 characters.',
            'discount.numeric' => 'The discount must be a valid number.',
            'discount.min' => 'The discount must be at least 0.',
            'discount.max' => 'The discount cannot exceed 100.',
        ];
    }
}
