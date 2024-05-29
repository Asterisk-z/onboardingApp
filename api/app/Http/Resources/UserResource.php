<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstName' => $this->first_name,
            'lastName' => $this->last_name,
            'middleName' => $this->middle_name,
            'email' => $this->email,
            'group_email' => $this->group_email,
            'phone' => $this->phone,
            'nationality' => $this->userNationality->name,
            'nationality_code' => $this->userNationality->code,
            'role' => $this->role,
            'position' => $this->position ?? null,
            'category' => $this->category ?? null,
            'approval_status' => $this->approval_status,
            'update_payload' => $this->update_payload,
            'regId' => $this->reg_id,
            'img' => $this->img ? config('app.url') . '/storage/app/public/' . $this->img : null,
            'mandate_form' => $this->mandate_form ? config('app.url') . '/storage/app/public/' . $this->mandate_form : null,
            'institution' => $this->institution,
            'is_active' => $this->is_active,
            'createdAt' => $this->created_at,
            'application' => $this->application,
        ];
    }
}
