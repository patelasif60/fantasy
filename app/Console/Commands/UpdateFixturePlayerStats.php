<?php

namespace App\Console\Commands;

use App\Models\FixtureStats;
use App\Models\Season;
use Illuminate\Console\Command;
use Log;

class UpdateFixturePlayerStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:player-fixture-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update the players points and team points for specified fixture ids fixture stats';

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
        // $values = ['545|342', '545|354', '545|355', '545|358', '545|362', '545|364', '551|236', '551|341', '551|458', '551|461', '551|467', '551|469', '551|470', '551|946', '611|371', '611|373', '611|374', '611|378', '611|399', '611|401', '545|640', '545|659', '551|258', '686|779', '573|800', '640|352', '670|452', '686|782', '690|460', '710|432', '713|264', '734|257', '743|195', '750|207', '757|664', '581|383', '611|889', '613|83', '636|607', '718|396', '723|680', '748|557', '752|17', '759|882', '581|396', '640|361', '649|499', '670|463', '686|765', '690|341', '710|425', '723|689', '734|51', '750|231', '752|30', '757|654', '759|771'];

        $values = ['545|362'];

        $this->info('Total of '.count($values).' fixtures provided.');

        foreach ($values as $value) {
            [$fixture_id, $player_id] = explode('|', $value);

            $fixtureStats = FixtureStats::join('fixtures', function ($query) {
                $query->on('fixture_stats.fixture_id', '=', 'fixtures.id')
                                        ->where('fixtures.season_id', Season::getLatestSeason());
            })
                                ->where('player_id', $player_id)
                                ->get();

            Log::info('***** START Re-Calculating player points *****');
            Log::info('***** FixtureID '.$fixture_id.' *****');
            Log::info('***** PlayerID '.$player_id.' *****');
            Log::info('Total '.count($fixtureStats).' fixture stats available');
            $this->info('Total '.count($fixtureStats).' fixture stats available');
            foreach ($fixtureStats as $key => $fixtureStat) {
                Log::info('Calculating for '.$fixtureStat->id);
                $this->info('Calculating for '.$fixtureStat->id);
                $this->call('update:fixture-stats-points', ['fixture_stats'=>$fixtureStat]);
            }
            Log::info('***** END Re-Calculating player points *****');
            $this->info('***** END Re-Calculating player points *****');
        }
    }
}
