<?php

namespace App\Mail\Manager\OnlineSealedBidTransfer;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransferRoundClosedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $division;

    public $team;

    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($division, $team, $url)
    {
        $this->division = $division;
        $this->team = $team;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject(__('messages.online_sealed_bid_transfer.round_completed'))
                ->markdown('emails.manager.OnlineSealedBidTransfer.round_completed');
    }
}
