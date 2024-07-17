<?php

namespace App\Services;

use App\Repositories\LeaguePhaseRepository;

class LeaguePhaseService
{
    /**
     * The league phase repository instance.
     *
     * @var LeaguePhaseRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param LeaguePhaseRepository $repository
     */
    public function __construct(LeaguePhaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($gameweek, $size, $name)
    {
        return $this->repository->create($gameweek, $size, $name);
    }

    public function update($leagueSeries, $name)
    {
        return $this->repository->update($leagueSeries, $name);
    }
}
