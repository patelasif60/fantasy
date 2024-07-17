<?php

namespace App\Events\Manager\Divisions;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LeaguePaymentReminderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $emailDetails;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($emailDetails)
    {
        $this->emailDetails = $emailDetails;
    }
}
