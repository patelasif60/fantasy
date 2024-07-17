<?php

namespace App\Mail\Logs;

use App\Models\LogsRolloverData;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RolloverLogCompletedEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The LogsRolloverData that has been invited.
     *
     * @var LogsRolloverData
     */
    public $log;

    /**
     * Create a new message instance.
     *
     * @param LogsRolloverData $log
     */
    public function __construct(LogsRolloverData $log)
    {
        $this->log = $log;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Rollover leagues process completed')->markdown('emails.admin.logs.rollover');
    }
}
