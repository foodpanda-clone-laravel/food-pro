<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddMenuItemRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can add authorization logic if necessary
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
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'serving_size' => 'nullable|string|max:50',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Updated to validate image files
            'discount' => 'nullable|numeric|min:0|max:100', // Assuming discount is a percentage
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
            'name.required' => 'The menu item name is required.',
            'name.string' => 'The menu item name must be a valid string.',
            'name.max' => 'The menu item name cannot exceed 255 characters.',

            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',

            'category.required' => 'The category is required.',
            'category.string' => 'The category must be a valid string.',
            'category.max' => 'The category cannot exceed 100 characters.',

            'serving_size.string' => 'The serving size must be a valid string.',
            'serving_size.max' => 'The serving size cannot exceed 50 characters.',

            'image_path.image' => 'The file must be a valid image.',
            'image_path.mimes' => 'The image must be of type: jpeg, png, jpg, gif, svg.',
            'image_path.max' => 'The image size cannot exceed 2MB.',

            'discount.numeric' => 'The discount must be a valid number.',
            'discount.min' => 'The discount must be at least 0%.',
            'discount.max' => 'The discount cannot exceed 100%.',
        ];
    }
}
