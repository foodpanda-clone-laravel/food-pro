<?php

namespace App\Http\Requests;

use App\Models\Variation;
use Illuminate\Foundation\Http\FormRequest;

class ValidateVariationRequest extends FormRequest
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


    public function rules()
    {
        return [

        ];
    }
    public function messages(){
        return [];
    }
}
