<?php

namespace App\DTO;

class CartItemDTO extends BaseDTO
{

    public function __construct(array $data) {
        $this->session_id = $data['session_id'];
        $this->menu_item_id = $data['menu_item_id'];
        $this->quantity = $data['quantity'];
        $this->selected_variations = $data['variations'];
        $this->selected_addons =$data['addons'];
    }
}
