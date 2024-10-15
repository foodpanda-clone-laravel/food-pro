<?php

namespace App\Http\Requests\CartRequests;
use App\Http\Requests\BaseRequest;
class AddToCartRequest extends BaseRequest
{
  

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'menu_item_id'=>'required|exists:menu_items,id'
        ];
    }
    public function messages(){
        return [
            'menu_item_id.required'=>'Menu item id is required',
            'menu_item_id.exists'=>'Invalid Menu Item id',
        ];
    }
}
