<?php

namespace App\Http\Resources\Education;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EventInvitationWithEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return $this->event->getBasicData();
    }
}
