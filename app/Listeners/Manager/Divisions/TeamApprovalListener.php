<?php

namespace App\Listeners\Manager\Divisions;

use App\Events\Manager\Divisions\TeamApprovalEvent;
use App\Mail\Manager\Divisions\TeamApprovalMail;
use Illuminate\Support\Facades\Mail;

class TeamApprovalListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function handle(TeamApprovalEvent $event)
    {
        Mail::to($event->user->email)->send(new TeamApprovalMail($event->team, $event->user));
    }
}
