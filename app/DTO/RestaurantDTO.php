<?php

namespace App\DTO;

use DateTime;

class RestaurantDTO extends BaseDTO
{
   
    public function __construct($data) {
        $this->name = $data["restaurant_name"];
        $this->owner_id = $data["owner_id"];
        $this->opening_time = DateTime::createFromFormat('H:i', $data["opening_time"])->format('H:i:s');
        $this->closing_time = DateTime::createFromFormat('H:i', $data["closing_time"])->format('H:i:s');
        $this->cuisine = $data["cuisine"];
        $this->logo_path = $data["logo_path"];
        $this->business_type = $data["business_type"];
    }
}
