<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamRecalculationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $team;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($team)
    {
        $this->team = $team;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $team = $this->team;

        return $this
            ->from(config('mail.from.address'), config('app.name'))
            ->subject('Team Recalculation Confirmation')
            ->view('emails.admin.teams.recalculation_confirmation', compact('team'));
    }
}
