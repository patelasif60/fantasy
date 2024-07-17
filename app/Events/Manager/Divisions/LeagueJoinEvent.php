<?php

namespace App\Events\Manager\Divisions;

use Illuminate\Foundation\Events\Dispatchable;

class LeagueJoinEvent
{
    use Dispatchable;

    public $team;
    public $division;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($team, $division)
    {
        $this->team = $team;
        $this->division = $division;
    }
}
