<?php

namespace App\DTO\Cart;

use App\DTO\BaseDTO;

class ShoppingSessionDTO extends BaseDTO
{
    public function __construct($data) {
        $this->user_id = $data['user_id'];
        $this->total = $data['total'] ?? 0.0;
        $this->expired_at = now()->addDays(1);
    }
}

