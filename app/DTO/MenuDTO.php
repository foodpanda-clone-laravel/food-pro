<?php

namespace App\DTO;

class MenuDTO extends BaseDTO
{
    public int $restaurant_id;
    public string $name;
    public string $description;
    public int $branch_id;

    public function __construct(
        int $restaurant_id,
        string $name,
        string $description,
        int $branch_id 
    ) {
        $this->restaurant_id = $restaurant_id;
        $this->name = $name;
        $this->description = $description;
        $this->branch_id = $branch_id;
    }
}
