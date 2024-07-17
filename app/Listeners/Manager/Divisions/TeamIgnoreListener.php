<?php

namespace App\Listeners\Manager\Divisions;

use App\Events\Manager\Divisions\TeamIgnoreEvent;
use App\Mail\Manager\Divisions\TeamIgnoreMail;
use Illuminate\Support\Facades\Mail;

class TeamIgnoreListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function handle(TeamIgnoreEvent $event)
    {
        Mail::to($event->user->email)->send(new TeamIgnoreMail($event->team, $event->user));
    }
}
