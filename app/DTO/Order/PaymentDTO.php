<?php

namespace App\DTO\Order;

use App\DTO\BaseDTO;

class PaymentDTO extends BaseDTO
{

    public function __construct(array $data) {
        $this->amount = $data['total_amount'];
        $this->user_id = $data['user_id'];
        $this->order_id = $data['id'];
    }
}
