<?php

namespace App\Console\Commands;

use App\Services\CustomCupFixtureService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CustomcupNextFixtures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customcupfixtures:generate-next {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate fixture for customcup';

    /**
     * @var CustomCupFixtureService
     */
    protected $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CustomCupFixtureService $service)
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
            echo "Invalid date, please pass Y-m-d date.\n";

            return;
        }

        info('Start custom cup process '.now());

        info('Generate next custom cup fixtures for '.$date);

        $this->service->generateNextFixtures(Carbon::parse($date));

        info('End custom cup process '.now());
    }
}
