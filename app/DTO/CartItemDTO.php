<?php

namespace App\DTO;

class CartItemDTO extends BaseDTO
{
    public int $session_id;     // The ID of the associated shopping session
    public int $menu_item_id;   // The ID of the menu item
    public int $quantity;        // The quantity of the menu item in the cart

    public function __construct(
        int $session_id,
        int $menu_item_id,
        int $quantity
    ) {
        $this->session_id = $session_id;
        $this->menu_item_id = $menu_item_id;
        $this->quantity = $quantity;
    }
}
