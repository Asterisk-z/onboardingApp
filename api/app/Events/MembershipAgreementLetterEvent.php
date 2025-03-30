<?php

namespace App\Events;

use App\Models\MemberAgreement;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MembershipAgreementLetterEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $agreement;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(MemberAgreement $agreement)
    {
        $this->agreement = $agreement;
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
