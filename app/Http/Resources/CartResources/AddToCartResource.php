<?php

namespace App\Http\Resources\CartResources;

use App\Models\Menu\MenuItem;
use Illuminate\Http\Resources\Json\JsonResource;

class AddToCartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "session_id"=> $this->session_id,
        "menu_item_id"=> $this->menu_item_id,
        "restaurant_id"=> $this->restaurant_id,
        "quantity"=> $this->quantity,
        "choice_group_id"=> $this->choice_group_id,
        "choice_id"=> $this->choice_id,
        "price"=> $this->price,
        "menu_item"=> MenuItem::find($this->menu_item_id)
        ];

     }
}
