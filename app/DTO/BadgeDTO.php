<?php

namespace App\DTO;

class BadgeDTO extends BaseDTO
{
    public string $name;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
    }
}
