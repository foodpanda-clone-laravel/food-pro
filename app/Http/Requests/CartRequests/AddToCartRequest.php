<?php

namespace App\Http\Requests\CartRequests;
use App\Http\Requests\BaseRequest;
use App\Rules\validateChoiceOptionRule;
use App\Rules\ValidVariationIds;

class AddToCartRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'menu_item_id'=>'required|exists:menu_items,id',
            'quantity'=>'required|integer',
            'variations' => ['required', new ValidVariationIds(), new validateChoiceOptionRule()],  // Apply custom validation rule to variations
            'addons'=>'json',
        ];
    }
    public function messages(){
        return [
            'menu_item_id.required'=>'Menu item id is required',
            'menu_item_id.exists'=>'Invalid Menu Item id',
            'variations.json'=>'Variation must be a valid json object',
            'addons.json'=>'Addons must be a valid json object',
        ];
    }
}
