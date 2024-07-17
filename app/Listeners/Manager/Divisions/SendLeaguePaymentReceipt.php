<?php

namespace App\Listeners\Manager\Divisions;

use App\Events\Manager\Divisions\LeagueTeamsPaymentEvent;
use App\Mail\Manager\Divisions\LeaguePaymentReceipt;
use Illuminate\Support\Facades\Mail;

class SendLeaguePaymentReceipt
{
    /**
     * Handle the event.
     *
     * @param  LeagueTeamsPaymentEvent  $event
     * @return void
     */
    public function handle(LeagueTeamsPaymentEvent $event)
    {
        $user = $event->paymentDetails['user'];
        Mail::to($user->email)
            ->send(new LeaguePaymentReceipt($event->paymentDetails));
    }
}
