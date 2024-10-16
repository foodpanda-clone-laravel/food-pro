<?php

namespace App\Http\Requests\MenuRequest;

use App\Http\Requests\BaseRequest;
class RequireChoiceGroupIdRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id'    =>'required|exists:choice_groups,id',
        ];
    }
}
