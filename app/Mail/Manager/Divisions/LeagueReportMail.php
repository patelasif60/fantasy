<?php

namespace App\Mail\Manager\Divisions;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LeagueReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $reportFile;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $reportFile)
    {
        $this->message = $message;
        $this->reportFile = $reportFile;
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
            ->subject('League Report - '.$this->message['divisionName'])
            ->markdown('emails.manager.divisions.league_report')
            ->attachData(utf8_decode($this->reportFile), 'League Report - '.$this->message['divisionName'].'.pdf');
    }
}
