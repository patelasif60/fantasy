<?php

namespace App\Events\Manager\Divisions;

use Illuminate\Foundation\Events\Dispatchable;

class LeagueTeamsPaymentEvent
{
    use Dispatchable;

    public $paymentDetails;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;
    }
}
