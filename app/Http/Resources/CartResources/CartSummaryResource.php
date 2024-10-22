<?php

namespace App\Http\Resources\CartResources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CartSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->user = $this->customer->user;

        return [
            'order_details' => [
                'items' => $this->items_total, // Assuming itemsTotal is accessible from the resource
                'total' => $this->total,
            ],
            'restaurant_details' => [
                'id' => $this->restaurant->id,
                'name' => $this->restaurant->name,
                'branch_id' => $this->branch->id,
                'restaurant_address'=>$this->branch->address,
            ],
            'delivery_details' => [
                'delivery_fee' => $this->branch->delivery_fee,
                'delivery_options' => $this->branch->delivery_time,
            ],
            'payment_method' => $this->customer->payment_method,
            'customer_details' => [
                'name' => $this->user->first_name . ' ' . $this->user->last_name,
                'email' => $this->user->email,
                'phone_number' => $this->user->phone_number,
                'delivery_address' => $this->customer->delivery_address,
            ],
        ];
    }
}
