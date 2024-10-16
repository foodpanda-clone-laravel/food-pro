<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray($request)
    {
        $restaurant = $this->restaurant;
        $averageRating = $restaurant->ratings->avg('stars') ?? 0; // Average restaurant rating
        $feedbacks = $restaurant->ratings->pluck('feedback')->all(); // Get all feedback for the restaurant
        $branchAddress = optional($restaurant->branches->first())->address ?? 'N/A'; // Get address from the branches

        // Format the menu items under the menu
        $menuItems = $this->menuItems->map(function ($menuItem) {
            return [
                'menu_item_name' => $menuItem->name,
                'price' => $menuItem->price,
                'description' => $menuItem->description,
                'image' => $menuItem->image_file,
            ];
        });

        return [
            'restaurant_logo' => $restaurant->logo_path,
            'restaurant_name' => $restaurant->name,
            'business_type' => $restaurant->business_type,
            'cuisine' => $restaurant->cuisine,
            'average_rating' => $averageRating,
            'feedbacks' => $feedbacks,
            'opening_time' => $restaurant->opening_time,
            'closing_time' => $restaurant->closing_time,
            'address' => $branchAddress,
            'menu_name' => $this->name, // Current menu's name
            'menu_items' => $menuItems, // List of menu items under this menu
        ];
    }
}
