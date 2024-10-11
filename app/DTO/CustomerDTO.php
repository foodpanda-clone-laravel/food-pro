<?php

namespace App\DTO;

class CustomerDTO extends BaseDTO
{
    public int $user_id;
    public ?string $address;
     public ?string $delivery_address; // nullable
    public $favorites; // this can be array or string depending on your choice
   
    public function __construct(    
         array $data
    ) {
        $this->user_id=$data['user_id'];
        $this->address = $data['address'] ?? null;
        $this->delivery_address = $data['delivery_address'] ?? null;
        $this->favorites =  $data['favorites'] ?? null;
    }
}
