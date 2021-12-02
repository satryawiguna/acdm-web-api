<?php


namespace App\Events\Broadcast;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendTobtEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $_departure;

    /**
     * Create a new event instance.
     *
     * @param array $departure
     */
    public function __construct(array $departure)
    {
        $this->_departure = $departure;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('departure');
    }

    public function broadcastWith()
    {
        return $this->_departure;
    }
}
