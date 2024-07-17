<?php

namespace App\Services;

use App\Repositories\PastWinnerHistoryRepository;

class PastWinnerHistoryService
{
    /**
     * The PastWinnerHistory repository instance.
     *
     * @var repository
     */
    protected $repository;

    public function __construct(PastWinnerHistoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($division, $data)
    {
        return $this->repository->create($division, $data);
    }

    public function update($history, $data)
    {
        return $this->repository->update($history, $data);
    }

    public function getHallOfFame($division)
    {
        return $this->repository->getHallOfFame($division);
    }
}
