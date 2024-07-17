<?php

namespace App\Services;

use App\Repositories\PlTableRepository;

class PlTableService
{
    /**
     * The chat repository instance.
     *
     * @var ChatRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param ChatRepository $repository
     */
    public function __construct(PlTableRepository $repository)
    {
        $this->repository = $repository;
    }

    public function stats()
    {
        return $this->repository->stats();
    }
}
