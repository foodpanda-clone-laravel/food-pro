<?php

namespace App\DTO;

class BadgeDTO extends BaseDTO
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
