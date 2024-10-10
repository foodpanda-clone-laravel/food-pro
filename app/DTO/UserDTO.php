<?php

namespace App\DTO;

use Illuminate\Support\Facades\Hash;

class UserDTO extends BaseDTO
{
    public string $first_name;
    public string $last_name;
    public ?string $phone_number; // Nullable field
    public string $email;
    public string $password;

    public function __construct($data) {
        $this->first_name = $data['first_name'];
        $this->last_name = $data['last_name'];
        $this->phone_number = $data['phone_number'] ?? null; // Optional, defaulting to null if not provided
        $this->email = $data['email'];
        $this->password = Hash  ::make(($data['password']));
    }
}
