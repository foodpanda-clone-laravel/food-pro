<?php

namespace App\Http\Resources\Rating;

use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            // 'restaurant_id' => $this->restaurant_id,
            // 'user_id' => $this->user_id,
            'feedback' => $this->feedback,
            'stars' => $this->stars,
        ];
    }
}
