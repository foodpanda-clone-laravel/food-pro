<?php

namespace App\DTO;

class RewardDTO extends BaseDTO
{
    public float $points;
    public int $user_id;
    public int $badge_id;
    public ?\DateTime $expired_at; // Nullable, since it can be null

    public function __construct(
        float $points,
        int $user_id,
        int $badge_id,
        ?\DateTime $expired_at = null // Default to null if not provided
    ) {
        $this->points = $points;
        $this->user_id = $user_id;
        $this->badge_id = $badge_id;
        $this->expired_at = $expired_at;
    }
}
