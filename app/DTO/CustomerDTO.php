<?php

namespace App\DTO;

class CustomerDTO extends BaseDTO
{
    public int $user_id;
    public string $address;
    public ?string $delivery_address; // Nullable
    public $favorites; // This can be an array or string depending on your choice

    public function __construct(array $data) {
        $this->user_id = $data['user_id'];
        $this->address = $data['address'];
        $this->delivery_address = $data['delivery_address'] ?? null; // Default to null if not provided
        $this->favorites = $data['favorites']; // Can be array or string based on input
    }
}
