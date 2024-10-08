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

    public function __construct(
        int $user_id,
        int $restaurant_id,
        int $branch_id,
        float $total_amount,
        string $status,
        string $order_type,
        float $delivery_charges,
        \DateTime $estimated_delivery_time
    ) {
        $this->user_id = $user_id;
        $this->restaurant_id = $restaurant_id;
        $this->branch_id = $branch_id;
        $this->total_amount = $total_amount;
        $this->status = $status;
        $this->order_type = $order_type;
        $this->delivery_charges = $delivery_charges;
        $this->estimated_delivery_time = $estimated_delivery_time;
    }
}
