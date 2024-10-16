<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActiveOrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'restaurant_name' => $this->restaurant->name,  // Optimized by only loading necessary fields
            'branch_address' => $this->branch->address,    // Fetch address directly
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'order_type' => $this->order_type,
            'delivery_charges' => $this->delivery_charges,
            'estimated_delivery_time' => $this->estimated_delivery_time,
            'order_items' => $this->orderItems->map(fn($orderItem) => [
                'id' => $orderItem->id,
                'menu_item_name' => $orderItem->menuItem->name,
                'quantity' => $orderItem->quantity,
                'item_price' => $orderItem->item_price,
                'addon_price' => $orderItem->addon_price,
                'total_price' => $orderItem->total_price,
                'addon_name' => $orderItem->addon_name,
                'menu_item_image' => $orderItem->menuItem->image_file
            ])
        ];
    }
}
