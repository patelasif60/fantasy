<?php

namespace App\Console\Commands;

use App\Services\ProcupFixtureService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ProcupFixtures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'procupfixtures:generate-initial {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate fixture for procup';

    /**
     * @var ProcupFixtureService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProcupFixtureService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = $this->argument('date');

        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }

        try {
            Carbon::parse($date);
        } catch (\Exception $e) {
            echo "invalid date, please pass Y-m-d date.\n";
            exit;
        }

        // get record from match with date range
        $gameweek = $this->service->getFirstGameWeekByGroupSize($date);
        if ($gameweek) { // get division groups
            $this->service->manageGroups($gameweek);
        } else {
            //echo "\nNo gameweek phases for pass date, no fixture generate";
        }
    }
}
