<?php
namespace App\DTO\ChoiceGroup;
class AssignedChoiceGroupDTO extends \App\DTO\BaseDTO{
    public function __construct($data){
        $data = $data->toArray();
        $this->choice_group_id=$data['choice_group_id'];
        $this->menu_item_id = $data['menu_item_id'];


    }
}
