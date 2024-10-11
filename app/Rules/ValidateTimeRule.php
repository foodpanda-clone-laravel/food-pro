<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateTimeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
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
        $pattern = '/^(?:[01]\d|2[0-3]):[0-5]\d$/';

        // Check if the value matches the regex
        return preg_match($pattern, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid time in 12-hour format (e.g., 09:00 AM or 05:30 PM).';

    }
}
