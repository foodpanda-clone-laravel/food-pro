<?php

namespace App\DTO;

class RestaurantOwnerDTO extends BaseDTO
{
    public string $cnic;
    public int $user_id;
    public string $bank_name;
    public string $iban;
    public string $account_owner_title;


    public function __construct($data) {
        $this->cnic = $data["cnic"];
        $this->user_id = $data["user_id"];
        $this->bank_name = $data["bank_name"];
        $this->iban = $data["iban"];
        $this->account_owner_title = $data["account_owner_title"];

    }
}
