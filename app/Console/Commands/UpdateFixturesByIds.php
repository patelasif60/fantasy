<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\FixtureEvent;
use App\Models\FixtureStats;
use Artisan;
use Illuminate\Console\Command;
use Log;

class UpdateFixturesByIds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:fixture-stats-by-ids';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old data and create new data for specified fixture ids fixture stats';

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
        Log::info('Start process for update fixture stats...');

        // $allFixtureIds = [545, 551, 611, 686, 573, 640, 670, 690, 710, 713, 734, 743, 750, 757, 581, 613, 636, 718, 723, 748, 752, 759, 649];

        // These fixtures holds manual events entry from admin side
        // $fids = [573, 640, 649, 670, 686, 690, 710, 713, 734, 748, 750, 752, 757];

        // These fixtures does not holds manual events entry from admin side
        // so we will refetch the opta feeds for these fixtures
        $fixtureIds = [545, 551, 611, 743, 581, 613, 636, 718, 723, 759];

        Log::info('Total of '.count($fixtureIds).' fixtures provided.');

        $fixtures = null;
        $fixtures = Fixture::whereIn('id', $fixtureIds)->get();

        if (! $fixtures) {
            Log::info('No fixture found.');

            return;
        }

        foreach ($fixtures as $key => $fixture) {
            Log::info('Process for fixture id . '.$fixture->id.'');
            FixtureStats::where('fixture_id', $fixture->id)->delete();
            FixtureEvent::where('fixture_id', $fixture->id)->delete();
            Log::info('Remove all data from fixture stats and events table.');
            Artisan::call('import:fixture-stats', ['--apikey' => $fixture->api_id]);
            Log::info('Fixture id: '.$fixture->id.' is processed.');
        }

        Log::info('Finished');
    }
}
