<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class validateChoiceOptionRule implements Rule
{
    public function __construct()
    {
        //
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

        $value = json_decode($value, true);
        $count = count($value);

        foreach($value as $item) {
            $variation = DB::table('variations')->where('id', $item['id'])->first();
            $choice_items = json_decode($variation->choice_items, true);
            if(!array_key_exists($item['choice'], $choice_items)){
                return false;
            };
        }
        return true;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected variation is invalid';
    }
}
