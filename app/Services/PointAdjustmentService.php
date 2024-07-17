<?php

namespace App\Services;

use App\Repositories\PointAdjustmentRepository;

class PointAdjustmentService
{
    /**
     * The PointAdjustment repository instance.
     *
     * @var PointAdjustmentRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param PointAdjustmentRepository $repository
     */
    public function __construct(PointAdjustmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($data)
    {
        return $this->repository->create($data);
    }
}
