<?php

namespace App\Mail\Manager\Divisions;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeagueJoinMail extends Mailable
{
    use Queueable, SerializesModels;

    public $team;
    public $division;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailDeatail)
    {
        // $this->team = $team;
        // $this->division = $division;
        $this->emailDeatail = $emailDeatail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailDeatail = $this->emailDeatail;
        $emailDeatail->leagueFirstName = ucfirst($emailDeatail->divisionTeam->division->consumer->user->first_name ? $emailDeatail->divisionTeam->division->consumer->user->first_name : $emailDeatail->divisionTeam->division->consumer->user->last_name);
        $emailDeatail->fristName = ucfirst($emailDeatail->consumer->user->first_name ? $emailDeatail->consumer->user->first_name : $emailDeatail->consumer->user->last_name);
        // return $this
        //         ->from($this->team->consumer->user->email)
        //         ->subject(__('messages.divisions.league_join').' - '.config('app.name'))
        //         ->markdown('emails.manager.divisions.league_join');
        return $this
                ->subject(__('messages.divisions.league_join'))
                ->view('emails.manager.divisions.league_join', compact('emailDeatail'));
    }
}
