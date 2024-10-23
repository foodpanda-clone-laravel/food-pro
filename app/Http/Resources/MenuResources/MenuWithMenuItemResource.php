<?php

namespace App\Http\Resources\MenuResources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MenuWithMenuItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)

        {

            return [
                'id' => $this->id,
                'menu_id' => $this->menu_id,
                'name' => $this->name,
                'price' => $this->price,
                'description' => $this->description,
                'image_file' => $this->image_path,
                'deleted_at' => $this->deleted_at,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'assigned_choices' => $this->AssignedChoiceGroups->map(function ($group) {
                    return [
                        'id' => $group->id,
                        'menu_item_id' => $group->menu_item_id,
                        'choice_group_id' => $group->choice_group_id,
                        'choice_group' => [
                            'id' => $group->choiceGroup->id,
                            'restaurant_id' => $group->choiceGroup->restaurant_id,
                            'name' => $group->choiceGroup->name,
                            'is_required' => $group->choiceGroup->is_required,
                            'choice_type' => $group->choiceGroup->choice_type,
                            'choices' => $group->choiceGroup->choices->map(function ($choice) {
                                return [
                                    'id' => $choice->id,
                                    'choice_group_id' => $choice->choice_group_id,
                                    'name' => $choice->name,
                                    'additional_price' => $choice->additional_price,
                                    'created_at' => $choice->created_at,
                                    'updated_at' => $choice->updated_at,
                                    'size_price' => $choice->size_price,
                                    'price' => $choice->price,
                                ];
                            }),
                        ],
                    ];
                }),
            ];
        }

}
