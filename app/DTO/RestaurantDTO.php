<?php

namespace App\DTO;

class RestaurantDTO extends BaseDTO
{
    public string $name;
    public int $owner_id;
    public ?string $opening_time;
    public ?string $closing_time;
    public string $cuisine;
    public ?string $logo_path;
    public string $business_type;

    public function __construct($data) {
        $this->name = $data["restaurant_name"];
        $this->owner_id = $data["owner_id"];
        $this->opening_time = $data["opening_time"].':00';
        $this->closing_time = $data["closing_time"].':00';
        $this->cuisine = $data["cuisine"];
        $this->logo_path = $data["logo_path"];
        $this->business_type = $data["business_type"];
    }
}
