<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;
class UpdateEmailRule implements Rule
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
        $userId = Auth::user()->id; // Get the current user's ID
        // Check if any other user has the same email
        return !User::where('email', $value)->where('id', '!=', $userId)->exists();

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The email is already taken';
    }
}
