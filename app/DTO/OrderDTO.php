<?php

namespace App\DTO;

class OrderDTO extends BaseDTO
{
    public int $user_id;
    public int $restaurant_id;
    public int $branch_id;
    public float $total_amount;
    public string $status; // Enum values: 'in progress','confirmed', 'prepared', 'delivered', 'canceled'
    public string $order_type; // Enum values: 'delivery', 'takeaway'
    public float $delivery_charges;
    public \DateTime $estimated_delivery_time;

    public function __construct(array $data) {
        $this->user_id = $data['user_id'];
        $this->restaurant_id = $data['restaurant_id'];
        $this->branch_id = $data['branch_id'];
        $this->total_amount = $data['total_amount'];
        $this->status = $data['status'];
        $this->order_type = $data['order_type'];
        $this->delivery_charges = $data['delivery_charges'];
        $this->estimated_delivery_time = $data['estimated_delivery_time'];
    }
}
