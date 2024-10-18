<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MenuResource extends JsonResource
{
    public function toArray($request)
    {
        // Generate the logo URL using the Storage::url() function
        $restaurantLogoUrl = $this->logo_path
            ? Storage::url($this->logo_path)
            : null;

        return [
            'restaurant' => [
                'id' => $this->id,
                'name' => $this->name,
                'business_type' => $this->business_type,
                'cuisine' => $this->cuisine,
                'average_rating' => $this->ratings->avg('stars') ?? 0,
                'feedbacks' => $this->ratings->pluck('feedback')->all(),
                'logo_url' => $restaurantLogoUrl,
                'opening_time' => $this->opening_time,
                'closing_time' => $this->closing_time,
                'branch_address' => optional($this->branches->first())->address ?? 'N/A',
            ],
            'menus' => $this->menus->map(function ($menu) {
                return [
                    'menu_name' => $menu->name,
                    'menu_items' => $menu->menuItems->map(function ($menuItem) {
                        return [
                            'menu_item_name' => $menuItem->name,
                            'price' => $menuItem->price,
                            'description' => $menuItem->description,
                            'image_url' => $menuItem->image_file ? Storage::url($menuItem->image_file) : null, // Generate the URL for the menu item image
                        ];
                    }),
                ];
            }),
        ];
    }
}