<?php

namespace App\Jobs;

use App\Mail\Manager\OnlineSealedBid\AuctionCompleted;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OnlineSealedBidsAuctionCompletedEmail implements ShouldQueue
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
        $info = route('manage.division.info', ['division' => $this->division]);

        $getApprovedTeams = $this->division->divisionApprovedTeams();
        foreach ($getApprovedTeams as $key => $value) {
            $user = $value->consumer->user;
            $data['league_name'] = $this->division->name;
            $data['league_link'] = $info;
            $data['first_name'] = ucfirst($user->first_name ? $user->first_name : $user->last_name);

            Mail::to($user->email)->send(new AuctionCompleted($data));
        }
    }
}
