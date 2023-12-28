<?php

namespace App\Http\Resources\Education;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventRegistrationWithEventResource extends JsonResource
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
            'status' => $this->status,

            'evidence_of_payment' => $this->evidence_of_payment,
            'evidence_of_payment_url' => $this->evidence_of_payment ? asset('storage/' . $this->evidence_of_payment) : null, // Adjust the path based on your storage setup

            'admin_remark' => $this->admin_remark,
            'user_remark' => $this->user_remark,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            'event' => $this->event->getBasicData(),
            'user' => $this->user->getBasicData(),

        ];
    }
}
