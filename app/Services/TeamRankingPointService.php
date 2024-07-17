<?php

namespace App\Services;

use App\Repositories\TeamRankingPointRepository;

class TeamRankingPointService
{
    /**
     * The TeamRankingPointRepository repository instance.
     *
     * @var TeamRankingPointRepository
     */
    public function __construct(TeamRankingPointRepository $repository)
    {
        $this->repository = $repository;
    }

    public function truncateCurrentPoints()
    {
        return $this->repository->truncateCurrentPoints();
    }

    public function getTotalTeams($data)
    {
        return $this->repository->getTotalTeams($data);
    }

    public function createSeasonRankingPoints($data)
    {
        return $this->repository->createSeasonRankingPoints($data);
    }

    public function createMonthRankingPoints($data)
    {
        return $this->repository->createMonthRankingPoints($data);
    }

    public function createWeekRankingPoints($data)
    {
        return $this->repository->createWeekRankingPoints($data);
    }

    public function getAveargePoints($data)
    {
        return $this->repository->getAveargePoints($data);
    }

    public function getAllLeagueSize($data)
    {
        return $this->repository->getAllLeagueSize($data);
    }

    public function getAllTeamSeasonPositions($data)
    {
        return $this->repository->getAllTeamSeasonPositions($data);
    }

    public function getAllTeamMonthPositions($data)
    {
        return $this->repository->getAllTeamMonthPositions($data);
    }

    public function getAllTeamWeekPositions($data)
    {
        return $this->repository->getAllTeamWeekPositions($data);
    }
}
