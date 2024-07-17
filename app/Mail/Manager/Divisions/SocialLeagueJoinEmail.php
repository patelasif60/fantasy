<?php

namespace App\Mail\Manager\Divisions;

use App\Models\Season;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SocialLeagueJoinEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param array $team
     */
    public function __construct($emailDetails)
    {
        $this->emailDetails = $emailDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $team = $this->emailDetails;
        $manager = $team->consumer->user;
        $team->fristName = ucfirst($manager->first_name ? $manager->first_name : $manager->last_name);
        $team->Season = Season::getLatestSeason();

        return $this
               ->subject(__('messages.divisions.social_league_join'))
               ->view('emails.manager.divisions.social_league_join', compact('team'));
    }
}
