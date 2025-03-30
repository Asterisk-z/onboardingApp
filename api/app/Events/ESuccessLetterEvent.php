<?php

namespace App\Events;

use App\Models\MemberESuccessLetter;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ESuccessLetterEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $letter;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MemberESuccessLetter $letter)
    {
        $this->letter = $letter;
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
