<?php

namespace App\Jobs;

use App\Mail\Manager\OnlineSealedBidTransfer\SealBidTransferEmail;
use App\Repositories\OnlineSealedBidTransferRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSealBidTransferEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $round;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($round)
    {
        $this->round = $round;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $onlineSealedBidTransferRepository = app(OnlineSealedBidTransferRepository::class);

        $sealBidDetails = $onlineSealedBidTransferRepository->getTeamPlayerDeatils($this->round)->groupBy('team_id');

        foreach ($sealBidDetails as $key => $bidDetails) {
            Mail::to($bidDetails[0]['manager_email'])->send(new SealBidTransferEmail($bidDetails));
        }
    }
}
