<?php

namespace App\DTO;

class DealDTO extends BaseDTO
{
    public string $name;
    public int $restaurant_id;
    public ?int $branch_id; // Nullable
    public ?float $discount; // Nullable discount

    public function __construct(
        string $name,
        int $restaurant_id,
        ?int $branch_id = null, // Default is null
        ?float $discount = null // Default is null
    ) {
        $this->name = $name;
        $this->restaurant_id = $restaurant_id;
        $this->branch_id = $branch_id; // Can be null or an int
        $this->discount = $discount; // Can be null or a float
    }
}
