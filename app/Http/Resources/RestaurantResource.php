<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RestaurantResource extends JsonResource
{
    public function toArray($request)
    {
        // Generate the image URL for the restaurant logo
        $logoUrl = $this->logo_path ? Storage::url($this->logo_path) : null;

        // Get the first deal and calculate discount
        $deal = $this->deals->first();
        $discount = $deal ? $deal->discount : 0;

        // Calculate the average rating
        $averageRating = $this->ratings->avg('stars') ?? 0;

        return [
            'restaurant_id' => $this->id,
            'image' => $logoUrl, // Image URL for frontend
            'name' => $this->name,
            'cuisine' => $this->cuisine,
            'rating' => $averageRating,
            'discount' => $discount,
            'deliveryTime' => optional($this->branches->first())->delivery_time ?? 'N/A',
            'deliveryFee' => optional($this->branches->first())->delivery_fee ?? 0,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time,
            'business_type' => $this->business_type,
        ];
    }
}
