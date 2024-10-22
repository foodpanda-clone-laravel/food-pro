<?php

namespace App\DTO\Customer;

use App\DTO\BaseDTO;

class RewardDTO extends BaseDTO
{
    public float $points;
    public int $user_id;
    public int $badge_id;
    public ?\DateTime $expired_at; // Nullable, since it can be null

    public function __construct($data) {
        $this->points = $data['points'];
        $this->user_id = $data['user_id'];
        $this->badge_id = $data['badge_id'];
        $this->expired_at = isset($data['expired_at']) ? new \DateTime($data['expired_at']) : null;
    }
}
