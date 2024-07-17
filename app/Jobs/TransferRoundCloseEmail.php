<?php

namespace App\Jobs;

use App\Mail\Manager\OnlineSealedBidTransfer\TransferRoundClosedEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class TransferRoundCloseEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $division;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($division)
    {
        $this->division = $division;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $teams = $this->division->divisionTeams()->with('consumer.user')->approve()->get();

        foreach ($teams as $team) {
            $url = route('manage.transfer.sealed.bid.bids', ['division' => $this->division, 'team' => $team]);

            Mail::to($team->consumer->user->email)->send(new TransferRoundClosedEmail($this->division, $team, $url));
        }
    }
}
