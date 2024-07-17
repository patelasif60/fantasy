<?php

namespace App\Services;

use App\Repositories\GameWeekRepository;

class GameWeekService
{
    /**
     * The GameWeek repository instance.
     *
     * @var GameWeekRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param GameWeekRepository $repository
     */
    public function __construct(GameWeekRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($season, $data)
    {
        return $this->repository->create($season, $data);
    }

    public function update($gameweek, $data)
    {
        return $this->repository->update($gameweek, $data);
    }

    public function getPreviousGameWeeksFromDate($date, $limit = null)
    {
        return $this->repository->getPreviousGameWeeksFromDate($date, $limit);
    }

    public function getGameWeekUsingSize($size, $division)
    {
        return $this->repository->getGameWeekUsingSize($size, $division);
    }

    public function getGameWeeks()
    {
        return $this->repository->getGameWeeks();
    }

    public function getGameWeeksValidCups()
    {
        return $this->repository->getGameWeeksValidCups();
    }

    public function getActiveGameWeek()
    {
        return $this->repository->getActiveGameWeek();
    }

    public function getLastActiveGameWeek()
    {
        return $this->repository->getLastActiveGameWeek();
    }

    public function getAllGameWeeks($division)
    {
        return $this->repository->getAllGameWeeks($division);
    }

    public function getCurrentGameWeek()
    {
        return $this->repository->getCurrentGameWeek();
    }
}
