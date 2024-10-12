<?php

namespace App\DTO;

class AddonDTO extends BaseDTO
{
    public int $restaurant_id;                // The ID of the associated menu item
    public string $choice_name;          // The name of the choice
    public  $choice_items;           // The items associated with the choice, stored as an array

    public function __construct(array $data)
    {
        $this->restaurant_id = $data['restaurant_id'];
        $this->choice_name = $data['choice_name'];
        $this->choice_items = json_encode($data['choice_items']); // Store as array
    }
}
