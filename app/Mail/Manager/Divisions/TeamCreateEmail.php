<?php

namespace App\Mail\Manager\Divisions;

use App\Models\Season;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TeamCreateEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param array $team
     */
    public function __construct($emailDetail)
    {
        $this->emailDetail = $emailDetail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailDetails = $this->emailDetail;
        $manager = $emailDetails->consumer->user;
        $emailDetails->fristName = ucfirst($manager->first_name ? $manager->first_name : $manager->last_name);
        $emailDetails->Season = Season::find(Season::getLatestSeason());

        return $this
            ->subject(__('messages.divisions.team_create'))
            ->view('emails.manager.divisions.team_create', compact('emailDetails'));
    }
}
