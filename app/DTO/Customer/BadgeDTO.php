<?php

namespace App\DTO\Customer;

use App\DTO\BaseDTO;

class BadgeDTO extends BaseDTO
{
    public string $name;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
    }
}
