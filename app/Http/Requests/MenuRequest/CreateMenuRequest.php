<?php

namespace App\Http\Requests\MenuRequest;
use App\Http\Requests\BaseRequest;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateMenuRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
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

        ];
    }


}
