<?php

namespace App\Http\Requests\MenuRequest;

use App\Http\Requests\BaseRequest;
use App\Rules\ValidateChoiceGroupsRule;

class AddChoiceGroupRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name'=>'required|string',
            'choices'=>'required|json',
            'is_required'=>'required|boolean',
            'choice_type'=>'required|string'
        ];
    }
    public function messages(){
        return [
            'name.required'=>'Choice group name is required',
            'name.string'=>'Choice group name must be string',
            'is_required.required'=>'Is choice is required',
            'choices.json'=>'Choice items should be a valid json object',
            'choice_type.required'=>'choice type is required',
            'choice_type.string'=>'choice type must be string',
        ];
    }
}
