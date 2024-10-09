<?php

namespace App\DTO;

class BranchDTO extends BaseDTO
{
    public string $address;
    public string $postal_code;
    public string $city;
    public int $restaurant_id;

    public function __construct(
        string $address,
        string $postal_code,
        string $city,
        int $restaurant_id
    ) {
        $this->address = $address;
        $this->postal_code = $postal_code;
        $this->city = $city;
        $this->restaurant_id = $restaurant_id;
    }
}
