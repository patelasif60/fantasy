<?php

namespace App\Console\Commands;

use App\Models\FixtureStats;
use App\Models\Season;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class PlayerPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'playerpoints:calculation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to recalculate player points based on fixture and player list';

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
        $daysInterval = config('fantasy.point_recalculation_days');
        $dtFrom = Carbon::now()->subDays($daysInterval)->format('Y-m-d 00:00:00');

        $fixtureStats = FixtureStats::join('fixtures', function ($query) use ($dtFrom) {
            $query->on('fixture_stats.fixture_id', '=', 'fixtures.id')
                ->where('fixtures.season_id', Season::getLatestSeason())
                ->where('fixtures.date_time', '>=', $dtFrom)
                ->where('fixtures.status', '=', 'Played');
        })->get();

        Log::info('***** START Re-Calculating player points *****');
        Log::info('Total '.count($fixtureStats).' fixture stats available');
        $this->info('Total '.count($fixtureStats).' fixture stats available');
        foreach ($fixtureStats as $key => $fixtureStat) {
            Log::info('Calculating for '.$fixtureStat->id);
            $this->info('Calculating for '.$fixtureStat->id);
            $this->call('recalculate:points', ['fixture_stats'=>$fixtureStat]);
        }
        Log::info('***** END Re-Calculating player points *****');
        $this->info('***** END Re-Calculating player points *****');
    }
}
