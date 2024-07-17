<?php

namespace App\Mail\Manager\Divisions;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeagueInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $invitationUrl;
    public $division;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param string $invitationUrl
     */
    public function __construct($invitationUrl, $division, $user)
    {
        $this->invitationUrl = $invitationUrl;
        $this->division = $division;
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
                ->from(config('mail.from.address'))
                ->subject(__('messages.divisions.join_a_league'))
                ->markdown('emails.manager.divisions.league_invitation');
    }
}
