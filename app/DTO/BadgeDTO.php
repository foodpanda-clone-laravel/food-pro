<?php

namespace App\DTO;

class RestaurantOwnerDTO extends BaseDTO
{
    public string $cnic;
    public int $user_id;
    public string $bank_name;
    public string $iban;
    public string $account_owner_title;
   

    public function __construct(
        string $cnic,
        int $user_id,
        string $bank_name,
        string $iban,
        string $account_owner_title,
        
    ) {
        $this->cnic = $cnic;
        $this->user_id = $user_id;
        $this->bank_name = $bank_name;
        $this->iban = $iban;
        $this->account_owner_title = $account_owner_title;
 
    }
}
