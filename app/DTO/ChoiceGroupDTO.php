<?php

namespace App\DTO;

class ChoiceGroupDTO extends BaseDTO
{

    public function __construct(array $data) {
        $this->restaurant_id= $data["restaurant_id"];
        $this->name = $data["name"];
        $this->is_required= $data["is_required"];
        $this->choice_type= $data["choice_type"];
    }
}
