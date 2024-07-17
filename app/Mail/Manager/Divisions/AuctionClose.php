<?php

namespace App\Mail\Manager\Divisions;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionClose extends Mailable
{
    use Queueable, SerializesModels;

    public $division;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($division)
    {
        $this->division = $division;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from(config('mail.from.address'))
            ->subject(__('messages.divisions.auction_close'))
            ->markdown('emails.manager.divisions.auction_close');
    }
}
