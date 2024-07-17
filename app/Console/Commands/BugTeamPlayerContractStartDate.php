<?php

namespace App\Console\Commands;

use App\Models\Season;
use App\Models\Transfer;
use App\Models\Division;
use Illuminate\Console\Command;
use App\Models\TeamPlayerContract;

class BugTeamPlayerContractStartDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:team-players-contracts-date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One time run command for update team player contracts';

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
        ini_set('memory_limit', '-1');

        $this->info('Start '.now());

        $season = Season::find(Season::getLatestSeason());
        
        $divisions = Division::with(['divisionTeams' => function($q) use($season) {
                        $q->where('season_id', $season->id);
                    }])
                    ->with('auctionRounds')
                    ->whereDate('auction_date','>=',$season->start_at)
                    ->whereNotNull('auction_date')->get();

        $this->info('Started auction division count = '.$divisions->count());

        foreach ($divisions as $division) {

            if($division->divisionTeams->count()) {

                $roundStartDate = $division->auction_date;
                if($division->auction_types == 'Online sealed bids') {
                    $firstReound = $division->auctionRounds ? $division->auctionRounds->first() : NULL;
                    if ($firstReound) {
                        $roundStartDate = $firstReound->start;
                    }
                }

                foreach ($division->divisionTeams as $team) {

                    if($team->pivot->season_id == $season->id) {

                        $this->info('Start update contract for team '.$team->id.' '.$team->name);
                        info('Start update contract for team '.$team->id.' '.$team->name);

                        $transfers = Transfer::where('team_id', $team->id)->where('transfer_type','auction')->get();

                        foreach ($transfers as $transfer) {

                            $contract = TeamPlayerContract::where('team_id', $team->id)->where('player_id', $transfer->player_in)->orderBy('id','ASC')->first();

                            if($contract) {

                                $transfer->transfer_date = $roundStartDate;
                                $transfer->save();

                                $contract->start_date = $roundStartDate;
                                $contract->save();
                                
                            }

                        }
                    }
                }

            }
        }

        $this->info('End '.now());
    }
}
