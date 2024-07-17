<?php

namespace App\Console\Commands;

use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Models\Division;
use App\Models\Fixture;
use App\Models\FixtureStats;
use App\Models\Season;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use App\Repositories\AuctionRepository;
use App\Services\AuctionService;
use Illuminate\Console\Command;

class UpdateTeamLineUpData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:team-lineup-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Team Lineup Reset';

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
        $this->info('Start process '.now().'');

        $dlt = \DB::select(\DB::raw('DELETE FROM team_player_contracts WHERE id = 122425'));
        $updt = \DB::select(\DB::raw('UPDATE team_player_contracts SET end_date = NULL WHERE id = 118061'));
        $updt = \DB::select(\DB::raw('UPDATE team_player_contracts SET end_date  = NULL WHERE id = 118102'));

        $dlt = \DB::select(\DB::raw('DELETE FROM transfers WHERE id = 108789'));
        $dlt = \DB::select(\DB::raw('DELETE FROM transfers WHERE id = 108790'));

        $division = Division::find(250);
        $item = Team::find(1805);

        $repository = app(AuctionRepository::class);
        $auctionService = app(AuctionService::class);

        $teamPlayers = $repository->getTeamPlayerContracts($item);
        $teamPlayers->filter(function ($value, $key) use ($division) {
            if ($division->getOptionValue('merge_defenders') == 'Yes') {
                if ($value->position == AllPositionEnum::CENTREBACK ||
                    $value->position == AllPositionEnum::FULLBACK
                ) {
                    return $value->setAttribute('position', AllPositionEnum::DEFENDER);
                }
            }

            if ($value->position == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
                return $value->setAttribute('position', AllPositionEnum::MIDFIELDER);
            }
        });

        $auctionService->setTeamFormations($division, $teamPlayers->groupBy('position'));

        $fixtures = Fixture::where('season_id', Season::getLatestSeason())
        ->whereDate('date_time', '<=', now())
        ->get();

        $contracts = TeamPlayerContract::where('team_id', $item->id)->whereNull('end_date')->get();

        foreach ($contracts as $contract) {
            foreach ($fixtures as $fixture) {
                $fixStats = FixtureStats::where('fixture_id', $fixture->id)->where('player_id', $contract->player_id)->first();

                if ($fixStats) {
                    \Artisan::call('recalculate:points', ['fixture_stats'=> $fixStats]);
                }
            }
        }

        $this->info('End process '.now().'');
    }
}
