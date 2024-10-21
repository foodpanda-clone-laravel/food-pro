<?php
namespace App\DTO\ChoiceGroup;
class AssignedChoiceGroupDTO extends \App\DTO\BaseDTO{
    public function __construct($menuItem, $choiceGroupId){
        $this->choice_group_id=$choiceGroupId;
        $this->menu_item_id = $menuItem->id;
    }
}
