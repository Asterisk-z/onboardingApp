<?php

namespace App\Traits;

use App\Models\Education\Event;
use App\Models\Education\EventRegistration;

trait EventTraits
{

    public function userEventRegistration(Event $event)
    {
        $registration = EventRegistration::where('event_id', $event->id)->where('user_id', auth()->user()->id)->first();
        return $registration;
    }
}
