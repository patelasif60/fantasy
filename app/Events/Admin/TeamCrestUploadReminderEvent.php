<?php

namespace App\Events\Admin;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TeamCrestUploadReminderEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $recipients;
    public $emailDetails;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($recipients, $emailDetails)
    {
        $this->recipients = $recipients;
        $this->emailDetails = $emailDetails;
    }
}
