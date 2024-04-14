<?php

namespace App\Events;

use App\Models\RegisteredStudent;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StudentEnrolled
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected RegisteredStudent $registeredstudent;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(RegisteredStudent $registeredstudent)
    {
        $this->registeredstudent = $registeredstudent;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
