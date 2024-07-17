<?php

namespace App\Console\Commands;

use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Models\Division;
use App\Models\TeamPlayerContract;
use App\Repositories\AuctionRepository;
use App\Services\AuctionService;
use DB;
use Illuminate\Console\Command;

class updateTeamFormation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:team-formation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update team formation which are generated incorrect';

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
        $this->info('Formation update started');
        /**
         *  Query to Get incorrect Division teams.
         */
        $repository = app(AuctionRepository::class);
        $service = app(AuctionService::class);

        $divisions = Division::join('division_teams', 'division_teams.division_id', '=', 'divisions.id')
            ->join('teams', 'division_teams.team_id', '=', 'teams.id')
            ->join('team_player_contracts', 'team_player_contracts.team_id', '=', 'teams.id')
            ->join('player_contracts as latest_player_contracts', function ($join) {
                $join->on('latest_player_contracts.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = team_player_contracts.player_id AND( ( ( divisions.auction_date >= player_contracts.start_date AND divisions.auction_date <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= divisions.auction_date)))'));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('players', 'players.id', '=', 'player_contracts.player_id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->selectRaw('COUNT(player_contracts.position),player_contracts.position,teams.id AS team_id,divisions.id AS division_id')
            ->whereNotNull('divisions.auction_closing_date')
            ->whereNull('team_player_contracts.end_date')
            ->where(function ($query) {
                $query->whereNULL('divisions.merge_defenders')
                    ->orWhere('divisions.merge_defenders', 'No');
            })
            ->where('player_contracts.position', 'Full-back (FB)')
            ->where('team_player_contracts.is_active', true)
            ->groupBy('player_contracts.position', 'team_player_contracts.team_id', 'divisions.id')
            ->havingRaw('COUNT(player_contracts.position) > ?', [2])
            ->get();

        foreach ($divisions as $key => $results) {
            $division = Division::find($results->division_id);
            $division->divisionTeams->where('is_approved', true)->each(function ($item, $key) use ($division, $results, $repository, $service) {
                if ($results->team_id == $item->id) {
                    $teamPlayers = $repository->getTeamPlayerContracts($item);
                    $teamPlayers->filter(function ($value, $key) use ($division) {
                        if ($value->position == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
                            return $value->setAttribute('position', AllPositionEnum::MIDFIELDER);
                        }
                    });

                    TeamPlayerContract::where('team_id', $item->id)
                        ->update(['is_active' => false]);

                    $service->setTeamFormations($division, $teamPlayers->groupBy('position'));
                }
            });
        }

        $this->info('Formation update complete');
    }
}
