<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SealBidAuctionPlayerAssignIssue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sealbid:player-assign-issue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One time command for player assign';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $except = ['71536', '73181','72997','72932','73017'];

        $bids = \App\Models\OnlineSealedBid::join('auction_rounds', 'auction_rounds.id', '=', 'online_sealed_bids.auction_rounds_id')
        ->whereNull('online_sealed_bids.status')
        ->where('auction_rounds.is_process','P')
        ->select('online_sealed_bids.*')
        ->get();

        $this->info('Affected bids count => '.$bids->count());

        $onlineSealedBidRepository = app(\App\Repositories\OnlineSealedBidRepository::class);

        $i = 1;
        foreach ($bids as $bid) {

            $team = $bid->team->load('consumer.user');

            if($team->team_budget >= $bid->amount) {

                $this->info($i.' Update Record for => '.$team->consumer->user->email.' Bid id '.$bid->id);

                if (in_array($bid->id, $except)) {

                    $bid->status = 'L';
                    $bid->save();

                } else  {
                    
                    $division = $team->teamDivision->first();
                    $teamIds = $division->divisionTeams->pluck('id')->toArray();
                    $cnt = \App\Models\TeamPlayerContract::whereIn('team_id',$teamIds)
                                ->where('player_id',$bid->player_id)
                                ->get();

                    if(!$division->auction_closing_date && !$cnt->count()) {

                        $bid->status = 'W';
                        $bid->save();
                        $onlineSealedBidRepository->createTeamPlayerContract($bid);
                    }
                }

                $i++;
            }
        }

        $this->info('Done');
    }
}