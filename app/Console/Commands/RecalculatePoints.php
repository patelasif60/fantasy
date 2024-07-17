<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\TeamPlayerContract;
use App\Services\TeamPlayerPointsService;
use Illuminate\Console\Command;

class RecalculatePoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recalculate:points {fixture_stats}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to recalculate team and player points based on fixture and player list';

    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TeamPlayerPointsService $service)
    {
        $this->service = $service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fixture_stats = $this->argument('fixture_stats');

        $fixture = Fixture::find($fixture_stats->fixture_id);
        //echo "Fixture at time - {$fixture->date_time} \n";
        $teamPlayerContracts = TeamPlayerContract::select('team_id', 'start_date', 'end_date', 'player_id')
             ->with(['player', 'team'])
             ->where('player_id', $fixture_stats->player_id)
             ->where('start_date', '<=', $fixture->date_time)
             ->where(function ($query) use ($fixture) {
                 $query->where('end_date', '>', $fixture->date_time)
                      ->orWhereNull('end_date');
             })
             ->where('is_active', true)
             ->get();

        if ($teamPlayerContracts->count() > 0) {
            foreach ($teamPlayerContracts as $contract) {
                $recalculate = $this->service->updateLivePoints($fixture_stats, $contract['team_id']);
                $recalculateRanking = $this->service->updateRankingPoints($fixture_stats, $contract['team_id']);

                //echo ($recalculate) ? "\tPoints are now calculated for {$contract->player->full_name} in Team - {$contract->team->name}\n\n" : '';
            }
        }
    }
}
