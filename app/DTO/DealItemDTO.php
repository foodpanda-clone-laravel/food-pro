<?php

namespace App\DTO;

class DealItemDTO extends BaseDTO
{
    public int $deal_id;         // The ID of the associated deal
    public int $menu_item_id;    // The ID of the associated menu item

    public function __construct(
        int $deal_id,
        int $menu_item_id
    ) {
        $this->deal_id = $deal_id;
        $this->menu_item_id = $menu_item_id;
    }
}
