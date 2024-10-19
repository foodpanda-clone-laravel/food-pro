<?php

namespace App\DTO\Menu;

use App\DTO\BaseDTO;

class MenuDTO extends BaseDTO
{
    public int $restaurant_id;
    public string $name;
    public int $branch_id;

    public function __construct($data) {
        $this->restaurant_id = $data['restaurant_id'];
        $this->name = $data['name'];
        $this->branch_id = $data['branch_id'];
    }
}
