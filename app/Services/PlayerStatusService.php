<?php

namespace App\Services;

use App\Repositories\PlayerStatusRepository;

class PlayerStatusService
{
    /**
     * The user repository instance.
     *
     * @var PlayerStatusRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param PlayerStatusRepository $repository
     */
    public function __construct(PlayerStatusRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($status)
    {
        return $this->repository->create($status);
    }

    public function update($status, $data)
    {
        return $this->repository->update($status, $data);
    }
}
