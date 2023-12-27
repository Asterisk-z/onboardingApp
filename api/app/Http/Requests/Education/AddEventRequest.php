<?php

namespace App\Http\Requests\Education;

use App\Models\Role;
use App\Models\User;
use App\Rules\EmailValidation;
use Illuminate\Foundation\Http\FormRequest;

class AddEventRequest extends FormRequest
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

            'name' => 'required|string',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i', // Assuming 'time' should be in the format HH:mm
            'is_annual' => 'required|in:0,1',
            'fee' => 'required|numeric|min:0',
            'img' => 'required|mimes:jpeg,png,jpg|max:10048',
            'registered_remainder_frequency' => 'nullable|in:Daily,Weekly,Monthly',
            'registered_remainder_dates' => 'nullable|string|required_if:registered_remainder_frequency,null',
            'unregistered_remainder_frequency' => 'nullable|in:Daily,Weekly,Monthly',
            'unregistered_remainder_dates' => 'nullable|string|required_if:unregistered_remainder_frequency,null',


        ];
    }
}
