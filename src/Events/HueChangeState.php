<?php

namespace MetaverseSystems\HuePHPBackend\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class HueChangeState implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $changes;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($changes = [])
    {
        $this->changes = $changes;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('Hue');
    }
}
