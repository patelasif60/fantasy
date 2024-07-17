<?php

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
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
        $emailDetails = $this->emailDetails;

        return $this
                ->subject(__('messages.auth.reset_password'))
                ->view('emails.auth.reset_password', compact('emailDetails'));
    }
}
