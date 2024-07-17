<?php

namespace App\Mail\Manager\OnlineSealedBid;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoundStartEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $team;

    /**
     * Create a new message instance.
     *
     * @param array $team
     */
    public function __construct($team)
    {
        $this->team = $team;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject(__('messages.online_sealed_bid.round_email'))
                ->markdown('emails.manager.OnlineSealedBid.round_start');
    }
}
