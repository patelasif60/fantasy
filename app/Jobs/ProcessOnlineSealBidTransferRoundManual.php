<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Enums\TiePreferenceEnum;
use Illuminate\Queue\SerializesModels;
use App\Enums\TransferRoundProcessEnum;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\OnlineSealedBidTransferService;

class ProcessOnlineSealBidTransferRoundManual implements ShouldQueue
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
        info('Online seal bid transfer round process start on '.now().'');

        $service = app(OnlineSealedBidTransferService::class);
        //On Round Process time check tie prefrence and assign tie number to team using league standing
        $tiePreference = $this->division->getOptionValue('tie_preference');
        $service->transferRoundTiePreferenceUsingScore($this->division, $tiePreference, $this->endRound);
        
        $onlineSealedBids = $service->getBidRoundData($this->endRound);
        if ($onlineSealedBids->count()) {
            info('Process start for round '.$this->endRound->end.'');
            $service->startOnlineSealedBidProcess($onlineSealedBids, $this->division, $this->endRound);
        } else {
            info('There is no bids found but closed the round');
            $service->roundClose($this->division, $this->endRound, false);
        }
        $this->division->roundProcess(false);

        info('Online seal bid round transfer process end on '.now().'');
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed()
    {
        info('The job failed to process of division seal bid transfer '.$this->division->id);

        $this->division->roundProcess(false);
    }
}
