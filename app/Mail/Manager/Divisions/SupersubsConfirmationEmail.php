<?php

namespace App\Mail\Manager\Divisions;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupersubsConfirmationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $team;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($team, $data)
    {
        $this->team = $team;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $team = $this->team;
        $data = $this->data;

        return $this
            ->from(config('mail.from.address'), config('app.name'))
            ->subject('Fantasy League Supersubs Confirmation')
            ->view('emails.manager.divisions.supersubs_confirmation', compact('team', 'data'));
    }
}
