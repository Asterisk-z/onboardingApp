<?php

namespace App\Http\Requests\Education;

use App\Models\Role;
use App\Models\User;
use App\Rules\EmailValidation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date',
            'time' => 'sometimes|date_format:H:i', // Assuming 'time' should be in the format HH:mm
            'is_annual' => 'sometimes|in:0,1',
            'fee' => 'sometimes|numeric|min:0',
            'img' => 'sometimes|mimes:jpeg,png,jpg|max:10048',
            'registered_remainder_frequency' => 'sometimes|nullable|in:Daily,Weekly,Monthly',
            'registered_remainder_dates' => 'sometimes|nullable|string',
            'unregistered_remainder_frequency' => 'sometimes|nullable|in:Daily,Weekly,Monthly',
            'unregistered_remainder_dates' => 'sometimes|nullable|string',
        ];
    }
}
