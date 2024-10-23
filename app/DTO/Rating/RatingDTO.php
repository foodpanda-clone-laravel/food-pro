<?php

namespace App\DTO\Rating;

use App\DTO\BaseDTO;
use App\Models\Orders\Order;

class RatingDTO extends BaseDTO
{

    public function __construct($data) {
        $this->order_id = $data->order_id;
        $this->user_id = $data->user_id;
        $this->feedback = $data->review;
        $this->stars = $data->rating;
        $order = Order::find($this->order_id);
        $this->restaurant_id = $order->restaurant_id;
    }
}
