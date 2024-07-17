<?php

namespace App\Console\Commands;

use App\Models\DivisionTeam;
use App\Models\Season;
use App\Services\TeamRankingPointService;
use Illuminate\Console\Command;

class CalculateRankingPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:team-ranking-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to calculate season overall team ranking points';

    protected $service;
    protected $season;
    protected $allLeagueSize;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TeamRankingPointService $service)
    {
        $this->service = $service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->service->truncateCurrentPoints();
        $this->season = Season::find(Season::getLatestSeason());
        if (! $this->season) {
            return false;
        }
        $this->info('Previous points cleared');
        $data['startDate'] = $this->season->start_at;
        $data['endDate'] = $this->season->end_at;
        $this->allLeagueSize = $this->service->getAllLeagueSize($data);
        $this->createSeasonRankingPoints();
        $this->createMonthRankingPoints();
        $this->createWeekRankingPoints();
        $this->info('Ranking points calcualtion finish');
    }

    private function createSeasonRankingPoints()
    {
        $this->info('Season teams Calculation');
        $data['startDate'] = $this->season->start_at;
        $data['endDate'] = $this->season->end_at;
        $averagePoints = $this->service->getAveargePoints($data);
        $teams = $this->service->getTotalTeams($data);
        $this->output->progressStart(count($teams));
        foreach ($teams as $key => $team) {
            $data = $this->prepareData($team, $averagePoints);
            if ($data) {
                $this->service->createSeasonRankingPoints($data);
            }

            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
    }

    private function createMonthRankingPoints()
    {
        $this->info('Month teams Calculation');
        $seasonMonths = carbon_get_months_between_dates($this->season->start_at, $this->season->end_at);
        $this->output->progressStart(count($seasonMonths));

        foreach ($seasonMonths as $seasonKey => $value) {
            $data['startDate'] = $value['startDate']->toDateTimeString();
            $data['endDate'] = $value['endDate']->toDateTimeString();
            $averagePoints = $this->service->getAveargePoints($data);
            $teams = $this->service->getTotalTeams($data);
            foreach ($teams as $key => $team) {
                $data = $this->prepareData($team, $averagePoints);
                if ($data) {
                    $data['start_at'] = $value['startDate']->toDateTimeString();
                    $data['end_at'] = $value['endDate']->toDateTimeString();
                    $this->service->createMonthRankingPoints($data);
                }
            }
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
    }

    private function createWeekRankingPoints()
    {
        $this->info('Weeks teams Calculation');
        $this->output->progressStart($this->season->gameweeks->count());

        foreach ($this->season->gameweeks as $seasonKey => $value) {
            $data['startDate'] = $value->start;
            $data['endDate'] = $value->end;
            $averagePoints = $this->service->getAveargePoints($data);
            $teams = $this->service->getTotalTeams($data);
            foreach ($teams as $key => $team) {
                $data = $this->prepareData($team, $averagePoints);
                if ($data) {
                    $data['start_at'] = $value->start;
                    $data['end_at'] = $value->end;
                    $this->service->createWeekRankingPoints($data);
                }
            }
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
    }

    private function getTeamDivision($teamId)
    {
        return DivisionTeam::where('team_id', $teamId)->first()->division;
    }

    private function getLeagueSize($divisionId)
    {
        $league = $this->allLeagueSize->where('division_id', $divisionId)
        ->first();
        if ($league) {
            return $league->league_size;
        }

        return false;
    }

    private function calculateRankingPointsOfTeam($data, $averagePoints)
    {
        return ((($data['total'] * (1 + (0.01 * ($data['league_size'] - 5))) - $data['transfers']) * (1 + (0.05 * (15 - $data['squad_size']))) * (1 + (0.05 * $data['weekend_changes'] * ($data['squad_size'] - 11)))) - $averagePoints) * 100;
    }

    private function prepareData($team, $averagePoints)
    {
        $division = $this->getTeamDivision($team->team_id);
        $leagueSize = $this->getLeagueSize($division->id);
        $data = [];
        if ($leagueSize) {
            $points = $team->total;
            $transfers = $team->transfers;
            $squadSize = $division->getOptionValue('default_squad_size');
            $weekendChanges = $division->allow_weekend_changes == 'Yes' ? 1 : 0;
            $data['season_id'] = $this->season->id;
            $data['team_id'] = $team->team_id;
            $data['total'] = $points;
            $data['league_size'] = $leagueSize;
            $data['squad_size'] = $squadSize;
            $data['transfers'] = $transfers;
            $data['weekend_changes'] = $weekendChanges;
            $rankingPoints = $this->calculateRankingPointsOfTeam($data, $averagePoints);
            $data['ranking_points'] = $rankingPoints;
        }

        return $data;
    }
}
