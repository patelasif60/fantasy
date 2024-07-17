<?php

namespace App\Mail\Manager\OnlineSealedBidTransfer;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SealBidTransferEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $bidDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($bidDetails)
    {
        $this->bidDetails = $bidDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
                ->subject(__('messages.online_sealed_bid_transfer.round_end'))
                ->markdown('emails.manager.OnlineSealedBidTransfer.round_end');
    }
}
