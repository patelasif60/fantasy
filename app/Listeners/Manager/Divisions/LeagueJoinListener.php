<?php

namespace App\Listeners\Manager\Divisions;

use App\Events\Manager\Divisions\LeagueJoinEvent;
use App\Mail\Manager\Divisions\LeagueJoinMail;
use Illuminate\Support\Facades\Mail;

class LeagueJoinListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(LeagueJoinEvent $event)
    {
        $team = $event->team;
        $division = $event->division;

        Mail::to($division->consumer->user->email)
                ->send(new LeagueJoinMail($team, $division));
    }
}
