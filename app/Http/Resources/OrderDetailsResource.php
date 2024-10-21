<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrderDetailsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'order_id' => $this->id,
            'order_image' => $this->restaurant->logo_path ? Storage::url($this->restaurant->logo_path) : null,
            'restaurant_name' => $this->restaurant->name ?? 'N/A',
            'restaurant_branch_address' => $this->branch ? $this->branch->address : 'N/A',
            'customer_address' => $this->customer ? $this->customer->delivery_address ?? 'N/A' : 'N/A',
            'delivery_date' => $this->created_at->format('Y-m-d H:i:s'),
            // 'delivery_date' => $this->delivery_date,
            // 'restaurant_branch_address' => $this->branch ? $this->branch->address : 'N/A',
            // 'customer_address' => $this->customer ? $this->customer->address : 'N/A',

            'order_items' => $this->orderItems->map(function ($orderItem) {
                return [
                    'id' => $orderItem->id,
                    'menu_item_name' => $orderItem->menuItem->name ?? 'N/A',
                    'quantity' => $orderItem->quantity,
                    'item_price' => $orderItem->item_price,
                    'addon_price' => $orderItem->addon_price,
                    'total_price' => $orderItem->total_price,
                    'addon_name' => $orderItem->addon_name,
                    'menu_item_image' => $orderItem->menuItem->image_file ? Storage::url($orderItem->menuItem->image_file) : null,
                ];
            })
        ];
    }
}
