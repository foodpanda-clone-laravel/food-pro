<?php

namespace App\DTO;

class PaymentDTO extends BaseDTO
{
    public float $amount;          // The amount of the payment
    public int $user_id;           // The ID of the user making the payment
    public int $order_id;          // The ID of the associated order

    public function __construct(
        float $amount,
        int $user_id,
        int $order_id
    ) {
        $this->amount = $amount;
        $this->user_id = $user_id;
        $this->order_id = $order_id;
    }
}
