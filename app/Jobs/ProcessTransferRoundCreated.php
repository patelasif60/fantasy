<?php

namespace App\Jobs;

use App\Mail\Manager\OnlineSealedBidTransfer\TransferRoundCreatedEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class ProcessTransferRoundCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $division;

    public $round;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($division, $round)
    {
        $this->division = $division;
        $this->round = $round;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (! $this->round) {
            return;
        }

        $teams = $this->division->divisionTeams()->with('consumer.user')->approve()->get();

        foreach ($teams as $team) {
            $url = route('manage.transfer.sealed.bid.bids', ['division' => $this->division, 'team' => $team]);

            Mail::to($team->consumer->user->email)->send(new TransferRoundCreatedEmail($this->division, $team, $this->round, $url));
        }
    }
}
