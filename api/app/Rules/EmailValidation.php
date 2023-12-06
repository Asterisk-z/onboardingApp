<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailValidation implements Rule
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
        //str_ends_with($value, '@fmdqgroup.com');
        $invalidEmailExt = ['gmail.com', 'yahoo.com', 'outlook.com'];
        $emailArray = explode('@', $value);
        $emailExt = $emailArray[1];

        return !in_array($emailExt, $invalidEmailExt);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid institution email.';
    }
}
