<?php

namespace App\DTO\Rating;

use App\DTO\BaseDTO;

class RatingDTO extends BaseDTO
{

    public function __construct($data) {
        $this->order_id = $data->order_id;
        $this->user_id = $data->user_id;
        $this->feedback = $data->feedback;
        $this->stars = $data->stars;
        $this->restuarant_id = $data->restuarant_id;
    }
}
