<?php

namespace App\Jobs;

use App\Mail\Manager\OnlineSealedBid\AuctionCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class OnlineSealedBidsAuctionCreatedEmail implements ShouldQueue
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
        $getApprovedTeams = $this->division->divisionApprovedTeams();

        $round = $this->division->auctionRounds()->first();
        $auction_round_start_date = get_date_time_in_carbon($round->start);
        $auction_round_end_date = get_date_time_in_carbon($round->end);

        foreach ($getApprovedTeams as $key => $value) {
            $data['auction_round_start_date'] = $auction_round_start_date;
            $data['auction_round_end_date'] = $auction_round_end_date;
            $user = $value->consumer->user;
            $data['league_name'] = $this->division->name;
            $data['first_name'] = ucfirst($user->first_name ? $user->first_name : $user->last_name);
            $data['team_name'] = ucfirst($value->name);
            $data['auction_summary_link'] = route('manage.auction.online.sealed.bid.index', ['division' => $this->division, 'type'=>'league']);
            $data['round_deadline_link'] = route('manage.auction.online.sealed.bid.teams', ['division' => $this->division, 'team'=> $value->id]);
            Mail::to($user->email)
            ->send(new AuctionCreated($data));
        }
    }
}
