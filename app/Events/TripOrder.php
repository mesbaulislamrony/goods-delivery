<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TripOrder
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $trip;

    public function __construct($trip)
    {
        $this->trip = $trip;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
