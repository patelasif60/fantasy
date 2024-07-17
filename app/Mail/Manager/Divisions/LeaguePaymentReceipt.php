<?php

namespace App\Mail\Manager\Divisions;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeaguePaymentReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $paymentDetails;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paymentDetails)
    {
        $this->paymentDetails = $paymentDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to($this->paymentDetails['toUser']->email)
            ->from(config('mail.from.address'), config('app.name'))
            ->subject(__('messages.divisions.league_payment_receipt'))
            ->markdown('emails.manager.divisions.payment_receipt');
    }
}
