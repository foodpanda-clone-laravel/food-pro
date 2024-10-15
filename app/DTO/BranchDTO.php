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
        $this->delivery_fee = $data["delivery_fee"]??0;
        $this->delivery_time = $data["delivery_time"]??'Standard delivery 15 to 30 minutes';
    }
}
