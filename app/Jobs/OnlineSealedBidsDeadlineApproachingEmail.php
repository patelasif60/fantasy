<?php

namespace App\Jobs;

use App\Mail\Manager\OnlineSealedBid\DeadlineApproaching;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OnlineSealedBidsDeadlineApproachingEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $auctionRound;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($auctionRound)
    {
        $this->auctionRound = $auctionRound;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->auctionRound) {
            foreach ($this->auctionRound as $key => $value) {
                $division = $value->division;
                $getApprovedTeams = $division->divisionApprovedTeams();
                foreach ($getApprovedTeams as $key => $value) {
                    $user = $value->consumer->user;
                    $data['league_name'] = $division->name;
                    $data['first_name'] = ucfirst($user->first_name ? $user->first_name : $user->last_name);
                    $data['team_name'] = ucfirst($value->name);
                    $data['auction_summary_link'] = route('manage.auction.online.sealed.bid.index', ['division' => $division, 'type'=>'league']);
                    $data['round_link'] = route('manage.auction.online.sealed.bid.teams', ['division' => $division, 'team'=> $value->id]);
                    Mail::to($user->email)
                    ->send(new DeadlineApproaching($data));
                }
            }
        }
    }
}
