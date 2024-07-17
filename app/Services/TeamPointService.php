<?php

namespace App\Services;

use App\Repositories\TeamPointRepository;

class TeamPointService
{
    /**
     * The transfer repository instance.
     *
     * @var TeamPointRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param TeamPointRepository $repository
     */
    public function __construct(TeamPointRepository $repository)
    {
        $this->repository = $repository;
    }
}
