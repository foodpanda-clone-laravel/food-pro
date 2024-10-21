<?php

namespace App\Http\Requests\CartRequests;

use App\Http\Requests\BaseRequest;
use App\Rules\ValidateMenuItemWithChoicesRule;

class AddToCartRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'required|integer',
            'variations' =>['json', new ValidateMenuItemWithChoicesRule($this->menu_item_id)]

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
