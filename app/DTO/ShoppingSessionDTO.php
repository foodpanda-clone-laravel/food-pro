<?php

namespace App\DTO;

class ShoppingSessionDTO extends BaseDTO
{
    public int $user_id;
    public float $total =0;
    public \DateTime $expired_at;

    public function __construct($data) {
        $this->user_id = $data['user_id'];
        $this->total = $data['total'] ?? 0;
        $this->expired_at = now()->addDays(1);
    }
}
