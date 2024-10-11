<?php

<<<<<<<< HEAD:app/Http/Requests/RestaurantOwnerRequests/AddOnRequest.php
namespace App\Http\Requests\RestaurantOwnerRequests;
========
namespace App\Http\Requests\MenuRequest;
>>>>>>>> main:app/Http/Requests/MenuRequest/AddOnRequest.php

use Illuminate\Foundation\Http\FormRequest;

class AddOnRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Authorization logic can be added if needed
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
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
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
            'name.required' => 'The add-on name is required.',
            'name.string' => 'The add-on name must be a valid string.',
            'name.max' => 'The add-on name cannot exceed 255 characters.',
            'category.required' => 'The category is required.',
            'category.string' => 'The category must be a valid string.',
            'category.max' => 'The category cannot exceed 100 characters.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',
        ];
    }


}
