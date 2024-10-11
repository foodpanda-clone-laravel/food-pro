<?php

namespace App\DTO;

class BranchDTO extends BaseDTO
{
    public string $address;
    public string $postal_code;
    public string $city;
    public int $restaurant_id;

    public function __construct($data) {
        $this->address = $data["address"];
        $this->postal_code = $data["postal_code"];
        $this->city = $data["city"];
        $this->restaurant_id = $data["restaurant_id"];
    }
}
