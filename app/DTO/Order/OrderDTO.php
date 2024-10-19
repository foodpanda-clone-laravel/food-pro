<?php

namespace App\DTO\Order;

use App\DTO\BaseDTO;

class OrderDTO extends BaseDTO
{
    public function __construct(array $data) {
        $this->user_id = $data['user_id'];
        $this->restaurant_id = $data['restaurant_id'];
        $this->branch_id = $data['branch_id'];
        $this->total_amount = $data['total_amount'];
        $this->status = 'in progress';
        $this->order_type = 'delivery';
        $this->delivery_charges = $data['delivery_charges'];
        $this->estimated_delivery_time = now()->addMinutes(15);
        $this->delivery_address = $data['delivery_address'];
    }
}
