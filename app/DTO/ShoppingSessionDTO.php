<?php

namespace App\DTO;

class ShoppingSessionDTO extends BaseDTO
{
    public int $user_id;         // The ID of the associated user
    public float $total;         // The total amount of the shopping session
    public \DateTime $expired_at; // The expiration date and time of the session

    public function __construct(
        int $user_id,
        float $total,
        \DateTime $expired_at
    ) {
        $this->user_id = $user_id;
        $this->total = $total;
        $this->expired_at = $expired_at;
    }
}
