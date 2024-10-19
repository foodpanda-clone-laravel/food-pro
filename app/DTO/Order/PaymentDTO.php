<?php

namespace App\DTO\Order;

use App\DTO\BaseDTO;

class PaymentDTO extends BaseDTO
{
    public float $amount;          // The amount of the payment
    public int $user_id;           // The ID of the user making the payment
    public int $order_id;          // The ID of the associated order

    public function __construct(array $data) {
        $this->amount = $data['amount'];
        $this->user_id = $data['user_id'];
        $this->order_id = $data['order_id'];
    }
}
