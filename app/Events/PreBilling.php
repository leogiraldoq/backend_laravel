<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PreBilling implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $prebillData;
    public $idUser;
    /**
     * Create a new event instance.
     */
    public function __construct($prebillData, $idUser)
    {
        $this->prebillData = $prebillData;
        $this->idUser = $idUser;
    }

    
    public function broadcastWith()
    {
        return ["data"=>json_encode($this->prebillData)];
    }
    
    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('qr.prebill.'.$this->idUser),
        ];
    }
}
