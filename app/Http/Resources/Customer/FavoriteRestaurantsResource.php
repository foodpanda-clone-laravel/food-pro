<?php

namespace App\Http\Resources\Customer;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteRestaurantsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $averageRating = round($this->ratings->avg('stars'), 2) ?? 0;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo_path' => $this->logo_path,
            'cuisine' => $this->cuisine,
            'opening_time' => $this->opening_time,
            'closing_time' => $this->closing_time,
            'average_rating' => $averageRating,
        ];
    }
}
