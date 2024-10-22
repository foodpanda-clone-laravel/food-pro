<?php

namespace App\DTO\Deal;

use App\DTO\BaseDTO;

class DealItemDTO extends BaseDTO
{
    public int $deal_id;         // The ID of the associated deal
    public int $menu_item_id;    // The ID of the associated menu item

    public function __construct(array $data) {
        $this->deal_id = $data['deal_id'];
        $this->menu_item_id = $data['menu_item_id'];
    }
}
