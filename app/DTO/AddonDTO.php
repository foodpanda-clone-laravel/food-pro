<?php

namespace App\DTO;

class AddonDTO extends BaseDTO
{

    public function __construct(array $data)
    {
        $this->restaurant_id = $data['restaurant_id'];
        $this->name = $data['name']; // choice item name
        $this->price  = $data['price']; // choice item price
        $this->choice_group_id = $data['choice_group_id'];
        $this->choice_items = $data['choice_items']??null;
//        $this->choice_items = json_encode($data['choice_items']); // Store as array
    }
}
