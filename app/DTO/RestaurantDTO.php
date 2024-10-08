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

    public function __construct(
        string $name,
        int $owner_id,
        int $branch_id,
        ?int $branches = null,
        string $address,
        string $postal_code,
        string $city,
        ?string $opening_time = null,
        ?string $closing_time = null,
        string $cuisine,
        ?string $logo_path = null,
        string $business_type
    ) {
        $this->name = $name;
        $this->owner_id = $owner_id;
        $this->branch_id = $branch_id;
        $this->branches = $branches;
        $this->address = $address;
        $this->postal_code = $postal_code;
        $this->city = $city;
        $this->opening_time = $opening_time;
        $this->closing_time = $closing_time;
        $this->cuisine = $cuisine;
        $this->logo_path = $logo_path;
        $this->business_type = $business_type;
    }
}
