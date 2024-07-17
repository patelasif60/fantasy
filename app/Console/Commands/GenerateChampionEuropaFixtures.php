<?php

namespace App\Console\Commands;

use App\Models\Season;
use App\Services\ChampionEuropaService;
use Illuminate\Console\Command;

class GenerateChampionEuropaFixtures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'championeuropa:generate-fixtures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate champions/europa fixtures at end of seasons';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * @var CompetitionService
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
        // if (config('fantasy.only_one_time_for_champion_euroapa')) {

        //     /**
        //      * Note as we are in between season
        //      * and we don't have previous season.
        //      * so we are managing both after season
        //      * + Between season work.
        //      */
        //     $date = now()->format('Y-m-d');
        //     $fixtureGenerationDate = '2019-11-23';

        //     if ($date === $fixtureGenerationDate) {
        //         $this->info('Start fixtures generation.');
        //         $this->service->createFixtures(Season::getLatestSeason());
        //         $this->info('Fixtures generated successfully.');
        //     } else {
        //         $this->info('Note a Valid date.');
        //     }

        //     exit();
        // }

        try {
            if (Season::getPreviousSeason()) {
                $season = Season::getPreviousSeason();
            } else {
                $this->info('No previous season exits.');
            }

            /*
              * Note change seasons to previous once data are perfect
              * This is only for testing purpose now.
              * Use Season::getPreviousSeason()
              * instead of Season::getLatestSeason()
              */
            if ($this->service->checkFixtureGenerated()) {
                return  $this->info('Fixtures already generated.');
            }

            $this->service->createFixtures();
            $this->info('Fixtures generated successfully.');
        } catch (\Exception $e) {
            $this->info('Error occured generating fixtures.');
        }
    }
}
