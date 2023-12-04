<?php

namespace App\Http\Requests\AR;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateARRequest extends FormRequest
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
            'ar_authoriser_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $user = User::find($value);
                    if (!$user) {
                        $fail('The authoriser does not exist.');
                    } else if ($user->role_id != Role::ARAUTHORISER) {
                        $fail('Invalid authoriser user');
                    } else if ($user->approval_status != User::APPROVED) {
                        $fail('Unapproved authoriser user');
                    }
                }
            ],

            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'position_id' => 'sometimes|exists:positions,id',
            'nationality' => 'sometimes|exists:nationalities,code',
            'role_id' => 'sometimes|in:' . Role::ARAUTHORISER . ',' . Role::ARINPUTTER,
            'email' => [
                'sometimes',
                'email',
            ],
            'phone' => [
                'sometimes',
                'regex:/^(070|080|091|090|081|071)\d{8}$/',
            ],
        ];
    }
}
