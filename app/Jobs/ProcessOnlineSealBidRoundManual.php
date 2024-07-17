<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Services\AuctionService;
use App\Services\OnlineSealedBidService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\OnlineSealedBidsAuctionCompletedEmail;

class ProcessOnlineSealBidRoundManual implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The division instance.
     *
     * @var division
     */
    protected $division;

    /**
     * The auction round instance.
     *
     * @var endRound
     */
    protected $endRound;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($division, $endRound)
    {
        $this->division = $division;
        $this->endRound = $endRound;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info('Online seabid process start....');

        $service = app(OnlineSealedBidService::class);
        $onlineSealedBids = $service->getManualBidRoundData($this->division, $this->endRound);

        if ($onlineSealedBids->count()) {

            $service->startOnlineSealedBidProcess($onlineSealedBids, $this->division, $this->endRound);

        } else {

            $auctionService = app(AuctionService::class);
            
            if ($auctionService->allTeamSizeFull($this->division)) {
                $this->endRound->processed();
                $auctionService->close($this->division);
                OnlineSealedBidsAuctionCompletedEmail::dispatch($this->division);
            }

            info('No records found....');
        }

        $this->division->roundProcess(false);

        

        info('Online seabid process end....');
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
