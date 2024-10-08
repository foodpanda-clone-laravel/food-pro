<?php

namespace App\DTO;

class CustomerDTO extends BaseDTO
{
    public int $user_id;
    public string $address;
    public ?string $delivery_address; // nullable
    public $favorites; // this can be array or string depending on your choice
   

    public function __construct(
       
        string $address,
        ?string $delivery_address,
        $favorites,
      
    ) {
      
        $this->address = $address;
        $this->delivery_address = $delivery_address;
        $this->favorites = $favorites;
        
    }
}
