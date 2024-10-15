<?php

namespace App\DTO;

class CartItemDTO extends BaseDTO
{
    public int $session_id;     // The ID of the associated shopping session
    public int $menu_item_id;   // The ID of the menu item
    public int $quantity;        // The quantity of the menu item in the cart

    public function __construct(array $data) {
        $this->session_id = $data['session_id'];
        $this->menu_item_id = $data['menu_item_id'];
        $this->quantity = $data['quantity'];
    }
}
