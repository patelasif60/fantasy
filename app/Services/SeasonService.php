<?php

namespace App\Services;

use App\Jobs\RolloverLeaguesJob;
use App\Repositories\SeasonRepository;

class SeasonService
{
    /**
     * The season repository instance.
     *
     * @var SeasonRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param SeasonRepository $repository
     */
    public function __construct(SeasonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($season)
    {
        return $this->repository->create($season);
    }

    public function update($season, $data)
    {
        return $this->repository->update($season, $data);
    }

    public function getSeasonNames()
    {
        return $this->repository->getSeasons()->pluck('name', 'id');
    }

    public function rollover($season, $data)
    {
        RolloverLeaguesJob::dispatch($season, $data);

        return $season;
    }

    public function getSeasonsFromIds($seasons)
    {
        return $this->repository->getSeasonsFromIds($seasons);
    }

    public function getAllPackages()
    {
        return $this->repository->getAllPackages()->pluck('name', 'id');
    }

    public function getLatestEndSeason()
    {
        return $this->repository->getLatestEndSeason();
    }
}
