<?php

namespace App\DTO\Rating;

use App\DTO\BaseDTO;

class RatingDTO extends BaseDTO
{
    public int $order_id;
    public int $user_id;
    public string $feedback;
    public int $stars; // Fixed the typo: changed 'starts' to 'stars'

    public function __construct(array $data) {
        $this->order_id = $data['order_id'];
        $this->user_id = $data['user_id'];
        $this->feedback = $data['feedback'];
        $this->stars = $data['stars'];
    }
}
