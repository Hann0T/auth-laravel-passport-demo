<?php

namespace App\Events;

use App\Models\Grade;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GradeUpdatedApi
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Grade $prevGrade;
    public Grade $newGrade;
    public $ip;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Grade $prevGrade, Grade $newGrade, $ip)
    {
        $this->prevGrade = $prevGrade;
        $this->newGrade = $newGrade;
        $this->ip = $ip;
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
