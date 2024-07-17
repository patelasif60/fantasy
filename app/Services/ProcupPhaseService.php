<?php

namespace App\Services;

use App\Repositories\ProcupPhaseRepository;

class ProcupPhaseService
{
    /**
     * The procup phase repository instance.
     *
     * @var ProcupPhaseRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param ProcupPhaseRepository $repository
     */
    public function __construct(ProcupPhaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($gameweek, $size, $name)
    {
        return $this->repository->create($gameweek, $size, $name);
    }

    public function update($proCup, $name)
    {
        return $this->repository->update($proCup, $name);
    }
}
