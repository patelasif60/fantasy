<?php

namespace App\Jobs;

use App\Services\OnlineSealedBidTransferService;
use App\Services\SealedBidTransferService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSingleTransferSealBid implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $division;

    public $team;

    public $sealbid;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($division, $team, $sealbid)
    {
        $this->division = $division;
        $this->team = $team;
        $this->sealbid = $sealbid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info('Process single sealBid start');
        $onlineSealedBidTransferService = app(OnlineSealedBidTransferService::class);
        $onlineSealedBidTransferService->createTeamPlayerContract($this->sealbid, $this->division);
        $onlineSealedBidTransferService->updateSuperSubTeamPlayer($this->team);
        ProcessTeamLineUpCheckAndReset::dispatch($this->division, $this->team);

        $isRoundCompleted = $onlineSealedBidTransferService->isRoundCompleted($this->sealbid->round);

        if ($isRoundCompleted) {
            $this->division->roundProcess(true);
            $sealedBidTransferService = app(SealedBidTransferService::class);
            $sealedBidTransferService->setSession();

            ProcessTransferRoundClosed::dispatch($this->division, $this->sealbid->round, false);
        }

        $this->division->roundProcess(false);

        info('Process single sealBid end');
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
