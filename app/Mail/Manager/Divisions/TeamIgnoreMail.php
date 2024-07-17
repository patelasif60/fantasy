<?php

namespace App\Mail\Manager\Divisions;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamIgnoreMail extends Mailable
{
    use Queueable, SerializesModels;

    public $team;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($team, $user)
    {
        $this->team = $team;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->from(config('mail.from.address'), config('app.name'))
                ->subject(config('app.name').' - '.__('messages.divisions.league_ignore'))
                ->markdown('emails.manager.divisions.team_ignore');
    }
}
