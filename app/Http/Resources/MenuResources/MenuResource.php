<?php

namespace App\Http\Resources\MenuResources;

use App\Models\ChoiceGroup\AssignedChoiceGroup;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MenuResource extends JsonResource
{
    public function toArray($request)
    {
        if($request->user()->customer){
            $favorites = $request->user()->customer->favourites->pluck('restaurant_id')->toArray();
        }
        else{
            $favorites = null;
        }
        return [
            'restaurant' => [
                'id' => $this->id,
                'name' => $this->name,
                'business_type' => $this->business_type,
                'image' => $this->logo_path,

                'is_favorite'=>$favorites?in_array($this->id, $favorites):false,

                'cuisine' => $this->cuisine,
                'average_rating' => round($this->ratings->avg('stars'), 1) ?? 0,
                'feedbacks' => $this->ratings->toArray(),
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
                                    'price' => $choice->price,
                                ];
                            });
                            return [
                                'id' => $assignedChoiceGroup->id,
                                'menu_item_id' => $assignedChoiceGroup->menu_item_id,
                                'choice_group_id' => $assignedChoiceGroup->choice_group_id,
                                'choice_group_name' => $assignedChoiceGroup->choiceGroup->name,
                                'is_required'=> $assignedChoiceGroup->choiceGroup->is_required,
                                'choice_type'=>$assignedChoiceGroup->choiceGroup->choice_type,
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
                            'image_url' => $menuItem->image_path
                        ];
                    })->toArray(),
                ];
            })->toArray(),
        ];
    }
}
