<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ValidVariationIds implements Rule
{
    public function passes($attribute, $value)
    {
        $value = json_decode($value, true);
        // Extract all the ids from the variations array
        $variationIds = array_column($value, 'id');

        $count = DB::table('variations')->whereIn('id', $variationIds)->count();
        return $count === count($variationIds); // Return true if all ids exist
    }

    public function message()
    {
        return 'One or more variation IDs are invalid or do not exist.';
    }
}
