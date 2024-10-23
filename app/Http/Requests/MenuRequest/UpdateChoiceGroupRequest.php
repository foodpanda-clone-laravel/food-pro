<?php

namespace App\Http\Requests\MenuRequest;


use App\Http\Requests\BaseRequest;
use App\Rules\UpdateChoicesValidationRule;

class UpdateChoiceGroupRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id'=>'required|integer|exists:choice_groups,id',
            'name'=>'sometimes|string',
            'choice_type'=>'sometimes|string',
            'is_required'=>'sometimes|boolean',
            'choices'=>['required','json', new UpdateChoicesValidationRule($this->input('id'))],
            'new_choices'=>'sometimes|json'
        ];
    }
    public function messages(){
        return [
            'id.required'=>'Choice Group id is required',
            'id.exists'=>'Choice Group id does not exists',
            'choice_type.string'=>'Choice Type should be string',
            'choices.json'=>'Choices  should be json',
            'new_choices.json'=>'New choices Type should be json'
        ];
    }
}
