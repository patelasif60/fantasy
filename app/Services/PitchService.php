<?php

namespace App\Services;

use App\Repositories\PitchRepository;

class PitchService
{
    /**
     * The PointAdjustment repository instance.
     *
     * @var PitchRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param PitchRepository $repository
     */
    public function __construct(PitchRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($data)
    {
        return $this->repository->create($data);
    }

    public function update($pitch, $data)
    {
        return $this->repository->update($pitch, $data);
    }

    public function crestDestroy($club)
    {
        return $this->repository->crestDestroy($club);
    }

    public function check($data)
    {
        return $this->repository->check($data);
    }
}
