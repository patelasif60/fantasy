<?php

namespace App\Events\Manager\Divisions;

use Illuminate\Foundation\Events\Dispatchable;

class TeamIgnoreEvent
{
    use Dispatchable;

    public $team;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($team, $user)
    {
        $this->team = $team;
        $this->user = $user;
    }
}
