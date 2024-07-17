<?php

namespace App\Console\Commands;

use App\Enums\EuropeanPhasesNameEnum;
use App\Services\ChampionEuropaService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class UpdateChampionEuropaFixtures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'championeuropa:update {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to update champions.europa fixtures points after gameweek';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * @var service
     */
    protected $service;

    public function __construct(ChampionEuropaService $service)
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
        $this->info('Start fixture points update.');

        $date = $this->argument('date');

        if (empty($date)) {
            $date = now()->format('Y-m-d');
        }

        try {
            Carbon::parse($date);

            $championsGameWeek = $this->service->getPreviousGameWeek($date, EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE);
            if (! $championsGameWeek) {
                $this->info('No champions gameweek phases for passed date, No fixtures are updated.');
            } else {
                $this->service->updateTournamentFixtures($championsGameWeek);
                $this->info('Updated champions fixture successfully.');
            }
            $europaGameWeek = $this->service->getPreviousGameWeek($date, EuropeanPhasesNameEnum::EUROPA_LEAGUE);
            if (! $europaGameWeek) {
                $this->info('No europa gameweek phases for passed date, No fixtures are updated.');
            } else {
                $this->service->updateTournamentFixtures($europaGameWeek);
                $this->info('Updated europa fixture successfully.');
            }
        } catch (\Exception $e) {
            $this->info('Invalid date, Required format(Y-m-d). or Error occured');
        }
    }
}
