<?php

namespace App\Http\Resources\AR;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ARTransferRequestResource extends JsonResource
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
            'approval_status' => $this->approval_status,
            'ar_user_id' => $this->ar_user_id,
            'requester_user_id' => $this->requester_user_id,
            'authoriser_id' => $this->authoriser_id,
            'update_payload' => $this->update_payload,
            'new_institution_id' => $this->new_institution_id,
            'request_reason' => $this->request_reason,
            'approval_reason' => $this->approval_reason,
            'mbg_approval_status' => $this->mbg_approval_status,

            'ar' => UserResource::make($this->ar),
            'requester' => UserResource::make($this->requester),
            'approver' => UserResource::make($this->approver),
            'new_institution' => $this->newInstitution,

            'createdAt' => $this->created_at,
        ];
    }
}
