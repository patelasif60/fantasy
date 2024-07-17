<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\Division;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeagueMessageReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $division;
    public $chat;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Division $division, Chat $chat)
    {
        $this->division = $division;
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('league.messages.'.$this->division->id);
    }
}
