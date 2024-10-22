<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DealResource extends JsonResource
{

    public function toArray($request)
    {
        $averageRating = round(optional($this->ratings->first())->avg_stars ?? 0, 1);

        $restaurantLogoUrl = $this->restaurant && $this->restaurant->logo_path
            ? Storage::url($this->restaurant->logo_path)
            : 'N/A';

        return [
            'id' => $this->id,
            'name' => $this->name,
            'restaurant_id' => $this->restaurant_id,
            'branch_id' => $this->branch_id,
            'discount' => $this->discount,
            'average_rating' => round($averageRating, 2),
            'restaurant_name' => optional($this->restaurant)->name ?? 'Unknown',
            'restaurant_logo' => $restaurantLogoUrl,
            'restaurant_cuisine' => optional($this->restaurant)->cuisine ?? 'N/A',
        ];
    }
}
