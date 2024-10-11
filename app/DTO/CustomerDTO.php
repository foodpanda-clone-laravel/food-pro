<?php

namespace App\DTO;

class CustomerDTO extends BaseDTO
{
    public int $user_id;
    public ?string $address;
    public ?string $delivery_address;
    public $favorites;

    public function __construct(
        ?string $address,
        ?string $delivery_address,
        $favorites = null
    ) {
        $this->address = $address;
        $this->delivery_address = $delivery_address;
        $this->favorites = $favorites ?? [];
    }
}