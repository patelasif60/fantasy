<?php

namespace App\Console\Commands;

use App\Models\GameWeek;
use App\Models\Season;
use App\Services\ChampionEuropaService;
use App\Services\DivisionService;
use Illuminate\Console\Command;

class GenerateChampionEuropaTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'championeuropa:generate-teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate champions/europa teams at end of seasons';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * @var DivisionService
     */
    protected $service;

    /**
     * @var ChampionEuropaService
     */
    protected $championEuropaService;

    public function __construct(DivisionService $service, ChampionEuropaService $championEuropaService)
    {
        parent::__construct();
        $this->service = $service;
        $this->championEuropaService = $championEuropaService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            if (Season::getLatestSeason()) {
                $season = Season::getLatestSeason();
            } else {
                $this->info('No latest season exits.');
            }

            $gameweek = GameWeek::where('season_id', Season::getPreviousSeason())->orderBy('end', 'desc')->first();

            $checkTeamexists = $this->championEuropaService->checkChampionEuropaGeneratedTeams(Season::getLatestSeason());

            if ($checkTeamexists) {
                return $this->info('Champions/europa teams already exits.');
            }

            if (now()->format('Y-m-d') > $gameweek->end) {
                $this->service->updateDivisionChampionEuropa(Season::getPreviousSeason());
                $this->info('Champions/europa teams created successfully.');
            } else {
                $this->info('Season not finished yet.');
            }
        } catch (\Exception $e) {
            $this->info('Error occured creating Champions/europa.');
        }
    }
}
