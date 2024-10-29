<?php

namespace App\Http\Resources\Rating;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = Auth::user();
        return [
            'id' => $this->id,
            'feedback' => $this->feedback,
            'stars' => $this->stars,
            'user' => [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ],
            'order' => [
                'id' => $this->order->id,
                'total_amount' => $this->order->total_amount,
                'menu_items' => $this->order->orderItems->map(function ($orderItem) {
                    return [
                        'id' => $orderItem->menuItem->id,
                        'image_file' =>$orderItem->menuItem->image_path,
                    ];
                }),
            ],
            'created_at' => $this->created_at,
        ];
    }
}
