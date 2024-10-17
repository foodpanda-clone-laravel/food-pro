<?php

namespace App\DTO;

class ChoiceItemsDTO extends BaseDTO
{

    public function __construct(array $data) {

        $this->choice_group_id= $data["choice_group_id"];
        $this->name = $data["name"];
//        if($data['choice_type']=='size'){
//            $this->size_price = $data['size_price']??0.0;
//        }
//        else{
//            $this->additional_price = $data['additional_price']??0.0;
//        }
        $this->size_price=$data["size_price"]??0.0;
        $this->additional_price=$data["additional_price"]??0.0;

        $this->price = $data["price"];
    }
}
