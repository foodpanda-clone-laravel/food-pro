<?php

namespace App\DTO;

class VariationDTO extends BaseDTO
{
    public int $menu_id;                // The ID of the associated menu item
    public string $choice_name;          // The name of the choice
    public string $choice_category;       // The category of the choice
    public mixed $choice_items;           // The items associated with the choice, stored as an array

    public function __construct(array $data)
     {
        $this->menu_id = $data['menu_id'];
        $this->choice_name = $data['choice_name'];
        $this->choice_category = $data['choice_category'];
        $this->choice_items = json_encode($data['choice_items']); // Store as JSON string, not array$data['choice_items']; 
    }
}
