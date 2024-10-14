<?php

namespace App\Http\Requests\CartRequests;

use App\Http\Requests\BaseRequest;
use App\Rules\ValidateChoiceGroupsRule;
use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequestV2 extends BaseRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer',
            'variations' =>['json', new ValidateChoiceGroupsRule($this->menu_item_id)]

        ];
    }
    public function messages(){
        return [
            'menu_item_id.required' => 'Menu item id is required.',
            'quantity.required' => 'Quantity is required.',
            'quantity.integer' => 'Quantity must be an integer.',
            'variations.json' => 'Variations must be valid JSON object.',
        ];
    }
}
