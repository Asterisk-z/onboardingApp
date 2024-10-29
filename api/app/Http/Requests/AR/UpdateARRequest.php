<?php

namespace App\Http\Requests\AR;

use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use App\Rules\EmailValidation;
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
                },
            ],

            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'middle_name' => 'sometimes|string',
            'position_id' => [
                'sometimes',
                'exists:positions,id',
                function ($attribute, $value, $fail) {
                    if (User::where('position_id', $value)->where('institution_id', auth()->user()->institution_id)->where('member_status', 'active')->exists()) {

                            // if (!Position::where('id', request('position_id'))->where('can_be_authorizer', true)->where('is_del', false)->exists()) {
                                $fail('Another User has the same position.');
                            // }

                    }
                }],
            'category_id' => 'required|exists:membership_categories,id',
            'nationality' => 'sometimes|exists:nationalities,code',
            'role_id' => [
                'sometimes',
                'in:' . Role::ARAUTHORISER . ',' . Role::ARINPUTTER,
                function ($attribute, $value, $fail) {
                    if (Role::ARAUTHORISER == $value) {
                        if (!Position::where('id', request('position_id'))->where('can_be_authorizer', true)->where('is_del', false)->exists()) {
                            $fail('Position can not be authoriser.');
                        }
                    }
                }],
            'email' => [
                'sometimes',
                'email',
                new EmailValidation,
            ],
            "img" => "nullable|mimes:jpeg,png,jpg|max:5048",
            'group_email' => 'sometimes|string',
            'phone' => [
                'sometimes',
                // 'regex:/^(070|080|091|090|081|071)\d{8}$/',
            ],
        ];
    }
}
