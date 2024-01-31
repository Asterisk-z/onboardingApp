<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ArAddedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $institutionId;
    public $newAr;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($institutionId, User $newAr)
    {
        $this->institutionId = $institutionId;
        $this->newAr = $newAr;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
