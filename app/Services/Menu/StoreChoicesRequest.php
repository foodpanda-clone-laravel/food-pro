<?php

namespace App\Http\Requests\MenuRequest;
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StoreChoicesRequest extends   BaseRequest
{
    public function authorize()
    {
        return true; // Change this to your authorization logic if needed
    }

    public function rules()
    {
        return [
            'isChoice' => 'required|boolean', // Ensure isChoice is present and is a boolean
            'choice_name' => 'required|string|max:255', // Required if isChoice is 1
            'choice_category' => 'required_if:isChoice,1|string|max:255', // Nullable for all cases
            'choice_items' => 'required', 
            // Add any other validation rules as needed
        ];
    }

    // Optional: Customize the error messages
    public function messages()
    {
        return [
            'isChoice.required' => 'The isChoice field is required.',
            'isChoice.boolean' => 'The isChoice field must be true or false.',
            'choice_name.required' => 'The choice name is required.',
            'choice_name.string' => 'The choice name must be a string.',
            'choice_name.max' => 'The choice name may not be greater than 255 characters.',
            'choice_category.required_if' => 'The choice category is required when isChoice is 1.',
            'choice_category.string' => 'The choice category must be a string.',
            'choice_category.max' => 'The choice category may not be greater than 255 characters.',
            'choice_items.required' => 'The choice items are required.',
        ];
    }
}
