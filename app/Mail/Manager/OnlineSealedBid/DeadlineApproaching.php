<?php

namespace App\Mail\Manager\OnlineSealedBid;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeadlineApproaching extends Mailable
{
    use Queueable, SerializesModels;

    public $emailDetails;

    /**
     * Create a new message instance.
     *
     * @return void
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
                ->subject(__('messages.online_sealed_bid.deadline_approaching'))
                ->view('emails.manager.OnlineSealedBid.deadline_approaching', compact('emailDetails'));
    }
}
