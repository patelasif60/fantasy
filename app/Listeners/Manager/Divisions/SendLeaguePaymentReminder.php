<?php

namespace App\Listeners\Manager\Divisions;

use App\Events\Manager\Divisions\LeaguePaymentReminderEvent;
use App\Mail\Manager\Divisions\LeaguePaymentReminder;
use Illuminate\Support\Facades\Mail;

class SendLeaguePaymentReminder
{
    /**
     * Handle the event.
     *
     * @param  LeagueTeamsPaymentEvent  $event
     * @return void
     */
    public function handle(LeaguePaymentReminderEvent $event)
    {
        $sent = Mail::to($event->emailDetails['recipients'])
            ->send(new LeaguePaymentReminder($event->emailDetails));
    }
}
