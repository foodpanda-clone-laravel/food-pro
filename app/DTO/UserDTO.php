<?php

namespace App\DTO;

class UserDTO extends BaseDTO
{
    public string $first_name;
    public string $last_name;
    public ?string $phone_number; // Nullable field
    public string $email;
    public string $password;

    public function __construct(
        string $first_name,
        string $last_name,
        ?string $phone_number = null,
        string $email,
        string $password
    ) {
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->phone_number = $phone_number;
        $this->email = $email;
        $this->password = $password;
    }
}
