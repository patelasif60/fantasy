<?php

namespace App\Mail\Manager\Divisions;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeagueCreateEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param array $team
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
               ->subject(__('messages.divisions.league_create'))
               ->view('emails.manager.divisions.league_create', compact('division'));
    }
}
