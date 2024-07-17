<?php

namespace App\Listeners;

use App\Events\NewAdminUserInvited;
use App\Mail\AdminUserInvitation;
use Illuminate\Support\Facades\Mail;

class SendAdminUserInvitation
{
    /**
     * Handle the event.
     *
     * @param NewAdminUserInvited $event
     * @return void
     */
    public function handle(NewAdminUserInvited $event)
    {
        Mail::to($event->user)->send(new AdminUserInvitation($event->user));
    }
}
