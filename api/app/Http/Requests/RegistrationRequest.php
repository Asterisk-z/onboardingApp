<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'nationality' => 'required|exists:nationalities,code',
            'category' => 'required|exists:membership_categories,id',
            'email' => ['email' , 'required',
                function ($attribute, $value, $fail) {
                    if(User::where('email', $value)->where('is_del', false)->exists()) {
                        $fail('The email has been taken.');
                    }
                }
            ],
            'phone' => ['required','regex:/^(070|080|091|090|081|071)\d{8}$/',
                    function ($attribute, $value, $fail) {
                        if(User::where('phone', $value)->where('is_del', false)->exists()) {
                            $fail('The phone has been taken.');
                        }
                    }
                ],
            'password' => 'required|string|min:6'
        ];
    }
}
