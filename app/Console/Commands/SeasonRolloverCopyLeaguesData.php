<?php

namespace App\Console\Commands;

use App\Models\Season;
use App\Jobs\RolloverLeaguesJob;
use Illuminate\Console\Command;

class SeasonRolloverCopyLeaguesData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rollover:leagues-copy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Leagues copy from old season to new season';

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
        
        $season = Season::find(Season::getLatestSeason());
        $data['duplicate_from'] = Season::getPreviousSeason();

        $this->info('Leagues data rollover start '.now());

        RolloverLeaguesJob::dispatch($season, $data);


        $this->info('Leagues data rollover end '.now());
    }
}
