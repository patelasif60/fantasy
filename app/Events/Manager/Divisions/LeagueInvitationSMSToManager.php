<?php

namespace App\Events\Manager\Divisions;

use Illuminate\Foundation\Events\Dispatchable;

class LeagueInvitationSMSToManager
{
    use Dispatchable;

    public $invitation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($invitation)
    {
        $this->invitation = $invitation;
    }
}
