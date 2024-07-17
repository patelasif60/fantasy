<?php

namespace App\Services;

use App\Repositories\FixtureRepository;

class FixtureService
{
    /**
     * The user repository instance.
     *
     * @var ClubRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param ClubRepository $repository
     */
    public function __construct(FixtureRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($fixture)
    {
        return $this->repository->create($fixture);
    }

    public function update($fixture, $data)
    {
        return $this->repository->update($fixture, $data);
    }

    public function playedRoundsList($division)
    {
        return $this->repository->playedRoundsList($division);
    }

    public function getCurrentFaCupRound($division)
    {
        return $this->repository->getCurrentFaCupRound($division);
    }
}
