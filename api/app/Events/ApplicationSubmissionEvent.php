<?php

namespace App\Events;

use App\Models\Application;
use App\Models\Institution;
use App\Models\MembershipCategory;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationSubmissionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $application;
    public $institution;
    public $membershipCategory;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Application $application, Institution $institution, MembershipCategory $membershipCategory)
    {
        $this->user = $user;
        $this->application = $application;
        $this->institution = $institution;
        $this->membershipCategory = $membershipCategory;
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
