<?php

namespace App\Services;

use App\Models\Team;
use App\Repositories\HeadToHeadFixtureRepository;

class HeadToHeadFixtureService
{
    /**
     * The HeadToHeadFixtureRepository instance.
     *
     * @var HeadToHeadFixtureRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param HeadToHeadFixtureRepository $repository
     */
    public function __construct(HeadToHeadFixtureRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getFixturesFromGameWeek($gameweek)
    {
        return $this->repository->getFixturesFromGameWeek($gameweek);
    }

    public function update($fixture, $data)
    {
        return $this->repository->update($fixture, $data);
    }

    public function getDivisionHeadToHeadTeamsScores($division)
    {
        return $this->repository->getDivisionHeadToHeadTeamsScores($division);
    }

    public function getDivisionHeadToHeadTeamsScoresFromGameWeek($division, $data = null)
    {
        $gameweek = '';
        $points = $this->repository->getDivisionHeadToHeadTeamsScoresFromGameWeek($division, $data);
        $teamIds = $points->pluck('homeTeamId')->merge($points->pluck('awayTeamId'))->unique();
        $teams = Team::whereIn('id', $teamIds)->get();

        $points = $points->map(function ($point) use ($teams, $gameweek) {
            if ($gameweek == '') {
                $gameweek = get_date_time_in_carbon($point->start.' '.'00:00:00')->format('d/m/y').' to '.get_date_time_in_carbon($point->end.' '.'00:00:00')->format('d/m/y');
            }

            $homeTeam = $teams->where('id', $point->homeTeamId)->first();
            $awayTeam = $teams->where('id', $point->awayTeamId)->first();
            $point['homeCrest'] = $homeTeam ? $homeTeam->getCrestImageThumb() : '';
            $point['awayCrest'] = $awayTeam ? $awayTeam->getCrestImageThumb() : '';
            $point['gameweek'] = $gameweek;

            return $point;
        });

        return $points;
    }
}
