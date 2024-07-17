<?php

namespace App\Services;

use App\Repositories\PrizePackRepository;

class PrizePackService
{
    /**
     * The package repository instance.
     *
     * @var repository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param PrizePackRepository $repository
     */
    public function __construct(PrizePackRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($prizePack)
    {
        return $this->repository->create($prizePack);
    }

    public function update($prizePack, $data)
    {
        return $this->repository->update($prizePack, $data);
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }
}
