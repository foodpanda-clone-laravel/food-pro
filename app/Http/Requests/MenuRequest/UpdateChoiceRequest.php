<?php

namespace App\Http\Requests\MenuRequest;

use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateChoiceRequest extends BaseRequest
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
            'choice_name' => 'nullable|string|max:255', // Required if isChoice is 1
            'choice_category' => 'nullable|string|max:255', // Nullable for all cases
            'choice_items' => 'nullable', 
            // Add any other validation rules as needed
        ];
    }
}
