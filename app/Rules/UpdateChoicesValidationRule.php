<?php

namespace App\Rules;

use App\Models\Menu\AssignedChoiceGroup;
use App\Models\Menu\Choice;
use Illuminate\Contracts\Validation\Rule;

class UpdateChoicesValidationRule implements Rule
{


    public function __construct($choiceGroupId)
    {
        $this->choiceGroupId = $choiceGroupId;
    }
    public function passes($attribute, $value)
    {
        try{
            $choices = json_decode($value,  true);
            $choiceIds = array_column($choices, 'id');
            // check if all the choice ids for a certain choice group exists in that choice group in database
            $validatedChoices = Choice::where('choice_group_id', $this->choiceGroupId)
                ->whereIn('id', $choiceIds)->pluck('id')->toArray();
            return count($validatedChoices) === $choiceIds;
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
