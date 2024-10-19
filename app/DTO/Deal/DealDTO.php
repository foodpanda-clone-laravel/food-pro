<?php

namespace App\DTO\Deal;

use App\DTO\BaseDTO;

class DealDTO extends BaseDTO
{
    public string $name;
    public int $restaurant_id;
    public ?int $branch_id; // Nullable
    public ?float $discount; // Nullable discount

    public function __construct(array $data) {
        $this->name = $data['name'];
        $this->restaurant_id = $data['restaurant_id'];
        $this->branch_id = $data['branch_id'] ?? null; // Default is null if not provided
        $this->discount = $data['discount'] ?? null; // Default is null if not provided
    }
}
