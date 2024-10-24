<?php

namespace App\DTO\Order;

use App\DTO\BaseDTO;

class OrderItemDTO extends BaseDTO
{
    // what should be in order items
    public function __construct(array $data) {
        $this->order_id = $data['id'];
        $this->menu_item_id = $data['menu_item_id'];
        $this->choice_id = $data['choice_id'];
        $this->quantity = $data['quantity'];
        $this->item_price = $data['price'];
        $this->total_price = $data['total_price'];
        $this->addon_name = $data['choice_names']??null;
        if($data['choice_type']=='size'){
            $this->size_price = $data['price'];
        }
        else{
            $this->addon_price = $data['total_price']- $data['price'];
        }
    }
}

