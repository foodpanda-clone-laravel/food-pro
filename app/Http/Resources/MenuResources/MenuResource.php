<?php

namespace App\Http\Resources\MenuResources;

use App\Models\Menu\AssignedChoiceGroup;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MenuResource extends JsonResource
{
    public function toArray($request)
    {
        // Generate the logo URL using the Storage::url() function

        return [
            'restaurant' => [
                'id' => $this->id,
                'name' => $this->name,
                'business_type' => $this->business_type,
                'cuisine' => $this->cuisine,
                'average_rating' => $this->ratings->avg('stars') ?? 0,
                'feedbacks' => $this->ratings->toArray(),
                'logo_url' => rtrim(env('APP_URL'), '/') . '/' . ltrim(Storage::url($this->logo_path), '/'),
                'opening_time' => $this->opening_time,
                'closing_time' => $this->closing_time,
                'branch_address' => optional($this->branches->first())->address ?? 'N/A',
            ],
            'menus' => $this->menus->map(function ($menu) {
                return [
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'menu_items' => $menu->menuItems->map(function ($menuItem) {
                        $choiceGroups = $menuItem->assignedChoiceGroups->map(function ($assignedChoiceGroup) {
                            $choiceGroup = AssignedChoiceGroup::find($assignedChoiceGroup->id)->choiceGroup;
                            $choices = $choiceGroup->choices->map(function ($choice) {
                                return [
                                    'id' => $choice->id,
                                    'name' => $choice->name,
                                    'additional_price' => $choice->additional_price,
                                    'size_price' => $choice->size_price,
                                    'price' => $choice->price,
                                ];
                            });
                            return [
                                'id' => $assignedChoiceGroup->id,
                                'menu_item_id' => $assignedChoiceGroup->menu_item_id,
                                'choice_group_id' => $assignedChoiceGroup->choice_group_id,
                                'created_at' => $assignedChoiceGroup->created_at,
                                'updated_at' => $assignedChoiceGroup->updated_at,
                                'choices' => $choices->toArray(), // Now choices will be associative
                            ];
                        });
                        return [
                            'menu_item_id' => $menuItem->id,
                            'menu_item_name' => $menuItem->name,
                            'choice_groups' => $choiceGroups->toArray(), // Now choice groups will be associative
                            'price' => $menuItem->price,
                            'description' => $menuItem->description,
                            'image_url' => $menuItem->image_file ? Storage::url($menuItem->image_file) : null, // Generate the URL for the menu item image
                        ];
                    })->toArray(),
                ];
            })->toArray(),
        ];
    }
}
