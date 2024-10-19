<?php

namespace App\DTO\Menu;

use App\DTO\BaseDTO;

class ChoiceItemsDTO extends BaseDTO
{

    public function __construct($data) {

        $this->choice_group_id= $data["choice_group_id"];
        $this->name = $data["name"];
        $this->size_price=$data["size_price"]??0.0;
        $this->additional_price=$data["additional_price"]??0.0;
        $this->price = $data["price"];
    }
}
