<?php

namespace App\Http\Resources\Education;

use App\Traits\EventTraits;
use Illuminate\Http\Resources\Json\JsonResource;

class EventInvitationWithEventResource extends JsonResource
{
    use EventTraits;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $event = $this->event->getBasicData();
        $otherInfo = [
            'registration' => $this->userEventRegistration($this->event),
        ];
        return array_merge($event, $otherInfo);
    }
}
