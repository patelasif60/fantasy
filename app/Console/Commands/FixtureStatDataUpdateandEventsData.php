<?php

namespace App\Console\Commands;

use App\Models\Fixture;
use App\Models\FixtureEvent;
use App\Models\FixtureStats;
use Artisan;
use Illuminate\Console\Command;

class FixtureStatDataUpdateandEventsData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:fixture-stats-events-data
                            {--A|apikey= : API key for particular fixture stats call back following the rate limit. M-6jkam124kzkjm5hxwzuroett6}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old fiture data and create new data for fixture stats and events';

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
        $this->info('Start process for update fixture stats...');

        $fixture = null;

        if ($this->option('apikey')) {

            $apikey = $this->option('apikey');

            if (! $apikey) {

                $this->info('Invalid API Key value.');

                return;
            }

            $fixture = Fixture::whereIn('status', ['Fixture', 'Playing', 'Played'])->where('api_id', $apikey)->first();

        } else {

            $this->info('Invalid API Key value.');

            return;
        }

        if (! $fixture) {

            $this->info('No fixture found.');

            return;
        }

        $this->info('Process for fixture id . '.$fixture->id.'');
        FixtureStats::where('fixture_id', $fixture->id)->delete();
        FixtureEvent::where('fixture_id', $fixture->id)->delete();
        $this->info('Remove all data from fixture stats and events table.');
        Artisan::call('import:fixture-stats', ['--apikey' => $fixture->api_id]);
        $this->info('Finished');
    }
}
