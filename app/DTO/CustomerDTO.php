<?php

namespace App\DTO;

class CustomerDTO extends BaseDTO
{
    public int $user_id;
    public ?string $address;
    public ?string $delivery_address;
    public $favorites;

    public function __construct(array $data) {
        $this->user_id = $data['user_id'];
        $this->address = $data['address'];
        $this->delivery_address = $data['delivery_address'] ?? null;
        $this->favorites = $data['favorites'];
    }
}
