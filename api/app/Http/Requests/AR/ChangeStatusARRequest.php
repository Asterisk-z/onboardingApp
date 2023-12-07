<?php

namespace App\Http\Requests\AR;

use App\Models\Role;
use App\Models\User;
use App\Rules\EmailValidation;
use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusARRequest extends FormRequest
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
            'request_type' => 'required|in:activate,deactivate',
            'reason' => 'nullable|string|max:120',
        ];
    }
}
