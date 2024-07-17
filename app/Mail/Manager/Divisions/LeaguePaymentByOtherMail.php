<?php

namespace App\Mail\Manager\Divisions;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaguePaymentByOtherMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @param array $team
     */
    public function __construct($emailDetail, $user)
    {
        $this->emailDetail = $emailDetail;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $emailDetails = $this->emailDetail;
        $user = $this->user;
        $manager = $emailDetails->consumer->user;
        $emailDetails->fristName = ucfirst($manager->first_name ? $manager->first_name : $manager->last_name);

        return $this
            ->subject(__('messages.divisions.league_Payment_other'))
            ->view('emails.manager.divisions.league_Payment_other', compact('emailDetails', 'user'));
    }
}
