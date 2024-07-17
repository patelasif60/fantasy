<?php

namespace App\Listeners\Admin;

use App\Mail\Admin\TeamCrestUploadReminder;
use Illuminate\Support\Facades\Mail;

class SendTeamCrestUploadReminder
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $sent = Mail::to($event->recipients)
            ->send(new TeamCrestUploadReminder($event->emailDetails));
    }
}
