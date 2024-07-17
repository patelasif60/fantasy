<?php

namespace App\Listeners\Manager\Divisions;

use App\Events\Manager\Divisions\LeagueInvitationSMSToManager;
use Twilio;

class SendLeagueInvitationSMSToManager
{
    /**
     * Handle the event.
     *
     * @param LeagueInvitationSMSToManager $event
     * @return void
     */
    public function handle(LeagueInvitationSMSToManager $event)
    {
        $message = $event->invitation['message'];

        if (isset($event->invitation['phones'])) {
            foreach ($event->invitation['phones'] as $key => $phone) {
                info('message sent to : '.$phone);
                Twilio::message($phone, $message);
            }
        }
    }
}
