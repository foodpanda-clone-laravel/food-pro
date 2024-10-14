<?php

namespace App\Rules;

use App\Models\Menu\AssignedChoiceGroup;
use Illuminate\Contracts\Validation\Rule;

class ValidateChoiceGroupsRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $menuItemId;

    // Constructor to accept menu_item_id
    public function __construct($menuItemId)
    {
        $this->menuItemId = $menuItemId;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // add a unique rule for choiceGroupIds columns
        $selectedVariations = json_decode($value,  true);

        $choiceGroupIds = array_column($selectedVariations, 'choice_group_id');

        $choiceIds = array_column($selectedVariations, 'choice_id');

        try{
            $validatedChoices = AssignedChoiceGroup::where('menu_item_id',1)
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

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected choice group is not valid.';
    }
}
