<?php

namespace App\Console\Commands;

use Artisan;
use Carbon\CarbonPeriod;
use Illuminate\Console\Command;

class HeadToHeadBugPointsCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'head-to-head-fixtures:update-bug-points
                            {--D|date= : date for particular gameweek to update points from. 2020-01-15}
                            ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One Time command to update head to head points';

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
        if ($this->option('date')) {
            $pastDate = $this->option('date');
            if (! $pastDate) {
                echo "Invalid past date value.\n";

                return;
            }
        } else {
            $pastDate = now()->format('Y-m-d');
        } 
        $this->info('Start Process of Head to Head Fixtures on '.now());

        $period = CarbonPeriod::create($pastDate, now()->format('Y-m-d'));

        foreach ($period as $date) {
            
            $date = $date;
            
            $this->info('Date => '.$date);
            
            Artisan::call('head-to-head-fixtures:update', ['--date' => $date]);
        }

        $this->info('End Process of Head to Head Fixtures on '.now());
    }
}
