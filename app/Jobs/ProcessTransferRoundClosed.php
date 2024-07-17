<?php

namespace App\Jobs;

use App\Services\OnlineSealedBidTransferService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTransferRoundClosed implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $division;

    public $round;

    public $sendEmail;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($division, $round, $sendEmail = null)
    {
        $this->division = $division;
        $this->round = $round;
        $this->sendEmail = $sendEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info('Round Process start');

        $onlineSealedBidTransferService = app(OnlineSealedBidTransferService::class);

        $onlineSealedBidTransferService->roundClose($this->division, $this->round, $this->sendEmail);

        $this->division->roundProcess(false);

        info('Round Closed');
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed()
    {
        info('The job failed to process of division'.$this->division->id);

        $this->division->roundProcess(false);
    }
}
