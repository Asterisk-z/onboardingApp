<?php

namespace App\Traits;

use App\Models\User;

trait UserTraits
{

    public function returnValue(User $user)
    {
        return [
            'id' => $user->id,
            'firstName' => $user->first_name,
            'lastName' => $user->last_name,
            'middleName' => $user->middle_name,
            'email' => $user->email,
            'fullName' => $user->full_name,
            'fullNameWithMail' => $user->full_name_with_mail,
            'group_email' => $user->group_email,
            'phone' => $user->phone,
            'nationality' => $user->userNationality->name,
            'nationality_code' => $user->userNationality->code,
            'role' => $user->role,
            'position' => $user->position ?? null,
            'category' => $user->category ?? null,
            'approval_status' => $user->approval_status,
            'update_payload' => $user->update_payload,
            'regId' => $user->reg_id,
            'img' => $user->img ? config('app.url') . '/storage/app/public/' . $user->img : null,
            'mandate_form' => $user->mandate_form ? config('app.url') . '/storage/app/public/' . $user->mandate_form : null,
            'institution' => $user->institution,
            'is_active' => $user->is_active,
            'createdAt' => $user->created_at,
            'application' => $user->application,
        ];
    }
}
