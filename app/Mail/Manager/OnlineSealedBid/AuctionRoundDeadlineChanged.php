<?php

namespace App\Mail\Manager\OnlineSealedBid;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionRoundDeadlineChanged extends Mailable
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
                ->subject(__('messages.online_sealed_bid.auction_round_deadline_changed'))
                ->view('emails.manager.OnlineSealedBid.auction_round_deadline_changed', compact('emailDetails'));
    }
}
