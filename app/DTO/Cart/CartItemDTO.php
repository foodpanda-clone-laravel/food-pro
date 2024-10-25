<?php

namespace App\DTO\Cart;

use App\DTO\BaseDTO;
use App\Models\ChoiceGroup\Choice;
use App\Models\ChoiceGroup\ChoiceGroup;
use App\Models\Menu\MenuItem;

class CartItemDTO extends BaseDTO
{

    public function __construct(array $data) {
        $this->session_id = $data['session_id'];
        $this->menu_item_id = $data['menu_item_id'];
        $menuItem = MenuItem::find($this->menu_item_id);
        $this->restaurant_id= $menuItem->menu->restaurant->id;
        $this->quantity = $data['quantity'];
        $this->choice_group_id = $data['variations'][0]['choice_group_id']??null;
        $this->choice_id = $data['variations'][0]['choice_id']??null;
        $choice = Choice::find($this->choice_id);
        if($choice->ChoiceGroup->choice_type=='size'){
            $this->price = $choice->price * $this->quantity;
        }
        else if ($choice->ChoiceGroup->choice_type=='additional'){
            $this->price = ($menuItem->price+$choice->price) * $this->quantity;
        }
    }
}
