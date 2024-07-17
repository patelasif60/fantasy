<?php

namespace App\Jobs;

use App\Mail\Manager\Divisions\LeagueReportMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendLeagueReportEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $recipient;
    public $message;
    public $reportFile;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recipient, $message, $reportFile)
    {
        $this->recipient = $recipient;
        $this->message = $message;
        $this->reportFile = $reportFile;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->recipient)
            ->send(new LeagueReportMail($this->message, $this->reportFile));
    }
}
