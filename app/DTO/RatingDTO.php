<?php

namespace App\DTO;

class RatingDTO extends BaseDTO
{
    public int $order_id;
    public int $user_id;
    public string $feedback;
    public int $stars; // Fixed the typo: changed 'starts' to 'stars'

    public function __construct(
        int $order_id,
        int $user_id,
        string $feedback,
        int $stars
    ) {
        $this->order_id = $order_id;
        $this->user_id = $user_id;
        $this->feedback = $feedback;
        $this->stars = $stars;
    }
}
