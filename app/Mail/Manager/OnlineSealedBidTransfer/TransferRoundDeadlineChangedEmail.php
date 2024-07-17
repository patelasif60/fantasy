<?php

namespace App\Mail\Manager\OnlineSealedBidTransfer;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TransferRoundDeadlineChangedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $division;

    public $team;

    public $round;

    public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($division, $team, $round, $url)
    {
        $this->division = $division;
        $this->team = $team;
        $this->round = $round;
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
                ->subject(__('messages.online_sealed_bid_transfer.round_deadline_changed'))
                ->markdown('emails.manager.OnlineSealedBidTransfer.round_deadline_changed');
    }
}
