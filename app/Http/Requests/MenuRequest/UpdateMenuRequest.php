<?php

namespace App\Http\Requests\MenuRequest;
use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class wUpdateMenuRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Authorize the user based on your logic
        return true; // Adjust this as necessary for your application
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255', // Allow the name to be optional
            'description' => 'nullable|string|max:1000', // Allow the description to be optional
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
            'name.string' => 'The menu name must be a string.',
            'name.max' => 'The menu name may not exceed 255 characters.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description may not exceed 1000 characters.',
        ];
    }
}
