<?php

namespace App\Listeners\Manager\Divisions;

use App\Events\Manager\Divisions\LeagueInvitationToManager;
use App\Mail\Manager\Divisions\LeagueInvitation;
use Illuminate\Support\Facades\Mail;

class SendLeagueInvitationToManager
{
    /**
     * Handle the event.
     *
     * @param LeagueInvitationToManager $event
     * @return void
     */
    public function handle(LeagueInvitationToManager $event)
    {
        $invitationUrl = $event->invitation['invitationUrl'];
        $division = $event->invitation['division'];
        $user = $event->invitation['user'];

        foreach ($event->invitation['emails'] as $key => $email) {
            Mail::to($email)
                    ->send(new LeagueInvitation($invitationUrl, $division, $user));
        }
    }
}
