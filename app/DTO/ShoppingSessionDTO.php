<?php

namespace App\DTO;

class ShoppingSessionDTO extends BaseDTO
{
    public int $user_id;         // The ID of the associated user
    public float $total;         // The total amount of the shopping session
    public \DateTime $expired_at; // The expiration date and time of the session

    public function __construct($data) {
        $this->user_id = $data['user_id'];
        $this->total = $data['total'];
        $this->expired_at = new \DateTime($data['expired_at']);
    }
}
