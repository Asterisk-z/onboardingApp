<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ValidArRole implements Rule
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
        // Check if the AR role_id exists in the users table with role_id 4 or 5
        return User::where('id', $value)->where('is_active', 1)->where('is_del', 0)->where(function ($query) {
            $query->where('role_id', 5)
                ->orWhere('role_id', 6);
        })->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected AR is invalid.';
    }
}
