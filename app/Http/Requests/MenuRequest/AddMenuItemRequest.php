<?php

namespace App\Http\Requests\MenuRequest;
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
            'variation_id' => 'nullable', // Ensure variation_id is an array, or can be null
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image files
            'description' => 'nullable|string|max:255',
            
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

            'variation_id.array' => 'The variations must be an array.',
            'variation_id.*.integer' => 'Each variation must be a valid integer.',
            'variation_id.*.exists' => 'The selected variation does not exist.',

            'image_path.image' => 'The file must be a valid image.',
            'image_path.mimes' => 'The image must be of type: jpeg, png, jpg, gif, svg.',
            'image_path.max' => 'The image size cannot exceed 2MB.',
        ];
    }
}
