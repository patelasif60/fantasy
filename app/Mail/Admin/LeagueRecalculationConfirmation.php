<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeagueRecalculationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $division;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($division)
    {
        $this->division = $division;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $division = $this->division;

        return $this
            ->from(config('mail.from.address'), config('app.name'))
            ->subject('League Recalculation Confirmation')
            ->view('emails.admin.teams.league_points_recalculation_confirmation', compact('division'));
    }
}
