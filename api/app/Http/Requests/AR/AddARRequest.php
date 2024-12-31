<?php

namespace App\Http\Requests\AR;

use App\Models\Position;
use App\Models\Role;
use App\Models\User;
use App\Rules\EmailValidation;
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
            'middle_name' => 'nullable|string',
            'position_id' => [
                'required',
                'exists:positions,id',
                function ($attribute, $value, $fail) {
                    if (User::where('position_id', $value)->where('institution_id', auth()->user()->institution_id)->where('member_status', 'active')->exists()) {

                        // if (!Position::where('id', request('position_id'))->where('can_be_authorizer', true)->where('is_del', false)->exists()) {
                        $fail('Another User has the same position.');
                        // }

                    }
                }],
            'nationality' => 'required|exists:nationalities,code',
            'category_id' => [
                'required',
                'exists:membership_categories,id',
                // function ($attribute, $value, $fail) {
                //     $total_ars = User::where('category_id', $value)->where('institution_id', auth()->user()->institution_id)->where('member_status', 'active')->count();
                //     $max_ar = (MembershipCategory::find($value))->max_ar;
                //     if ($total_ars >= $max_ar) {

                //         $fail('Available Authorised Representative Slot is full');

                //     }
                // }
            ],
            'role_id' => [
                'required',
                'in:' . Role::ARAUTHORISER . ',' . Role::ARINPUTTER,
                function ($attribute, $value, $fail) {
                    if (Role::ARAUTHORISER == $value) {
                        if (!Position::where('id', request('position_id'))->where('can_be_authorizer', true)->where('is_del', false)->exists()) {
                            $fail('Position can not be authoriser.');
                        }
                    }
                }],
            'email' => [
                'email',
                'required',
                function ($attribute, $value, $fail) {
                    if (User::where('email', $value)->where('is_del', false)->exists()) {
                        $fail('The email has been taken.');
                    }
                },
                new EmailValidation,
            ],
            'group_email' => 'required|string',
            "img" => "nullable|mimes:jpeg,png,jpg|max:5048",
            "mandate_form" => "required|mimes:jpeg,png,jpg,pdf|max:5048",
            'phone' => [
                'required',
                //'regex:/^(070|080|091|090|081|071)\d{8}$/',
                function ($attribute, $value, $fail) {
                    if (User::where('phone', $value)->where('is_del', false)->exists()) {
                        $fail('The phone has been taken.');
                    }
                },
            ],
        ];
    }
}
