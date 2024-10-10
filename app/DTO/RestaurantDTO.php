<?php

namespace App\DTO;

class RestaurantDTO extends BaseDTO
{
    public string $name;
    public int $owner_id;
    public int $branch_id;
    public ?int $branches;
    public string $address;
    public string $postal_code;
    public string $city;
    public ?string $opening_time;
    public ?string $closing_time;
    public string $cuisine;
    public ?string $logo_path;
    public string $business_type;

    public function __construct(array $data) {
        $this->name = $data['name'];
        $this->owner_id = $data['owner_id'];
        $this->branch_id = $data['branch_id'];
        $this->branches = $data['branches'] ?? null; // Nullable field
        $this->address = $data['address'];
        $this->postal_code = $data['postal_code'];
        $this->city = $data['city'];
        $this->opening_time = $data['opening_time'] ?? null; // Nullable field
        $this->closing_time = $data['closing_time'] ?? null; // Nullable field
        $this->cuisine = $data['cuisine'];
        $this->logo_path = $data['logo_path'] ?? null; // Nullable field
        $this->business_type = $data['business_type'];
    }
}
