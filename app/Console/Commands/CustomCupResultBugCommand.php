<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CustomCupResultBugCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customcup:generate-update-fixture-bug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'One time command for generate fixture and update firxture bug on live site';

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
        $this->info('Start Process of Custom cup on '.now());

        $period = \Carbon\CarbonPeriod::create('2019-10-25', now()->format('Y-m-d'));

        foreach ($period as $date) {
            $date = $date->format('Y-m-d');
            $this->info('Date => '.$date);
            \Artisan::call('customcupfixtures:generate', ['date' => $date]);
            \Artisan::call('customcupfixtures:update', ['date' => $date]);
            \Artisan::call('customcupfixtures:generate-next', ['date' => $date]);
        }

        $this->info('End Process of Custom cup on '.now());
    }
}
