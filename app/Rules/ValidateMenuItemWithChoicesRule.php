<?php

namespace App\Rules;

use App\Models\ChoiceGroup\AssignedChoiceGroup;
use Illuminate\Contracts\Validation\Rule;

class ValidateMenuItemWithChoicesRule implements Rule
{

    protected $menuItemId;

    // Constructor to initialize menu_item_id
    public function __construct($menuItemId)
    {
        $this->menuItemId = $menuItemId;
    }

    public function passes($attribute, $value)
    {
        // add a unique rule for choiceGroupIds columns
        $selectedVariations = json_decode($value,  true);

        $choiceGroupIds = array_column($selectedVariations, 'choice_group_id');

        $choiceIds = array_column($selectedVariations, 'choice_id');

        try{
            $validatedChoices = AssignedChoiceGroup::where('menu_item_id',$this->menuItemId)
                ->whereIn('choice_group_id', $choiceGroupIds)
                ->whereHas('choiceGroup.choices', function ($query) use ($choiceIds) {
                    $query->whereIn('id', $choiceIds);
                })
                ->firstOrFail();
            return true;
        }
        catch (\Exception $exception){
            return false;
        }
    }


    public function message()
    {
        return 'The selected choice group is not valid.';
    }
}
