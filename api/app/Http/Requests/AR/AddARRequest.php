<?php

namespace App\Http\Requests\AR;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AddARRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'position_id' => 'required|exists:positions,id',
            'nationality' => 'required|exists:nationalities,code',
            'role_id' => 'required|in:' . Role::ARAUTHORISER . ',' . Role::ARINPUTTER,
            'email' => [
                'email',
                'required',
                function ($attribute, $value, $fail) {
                    if (User::where('email', $value)->where('is_del', false)->exists()) {
                        $fail('The email has been taken.');
                    }
                }
            ],
            'phone' => [
                'required',
                'regex:/^(070|080|091|090|081|071)\d{8}$/',
                function ($attribute, $value, $fail) {
                    if (User::where('phone', $value)->where('is_del', false)->exists()) {
                        $fail('The phone has been taken.');
                    }
                }
            ],
        ];
    }
}
