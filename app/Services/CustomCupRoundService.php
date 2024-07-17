<?php

namespace App\Services;

use App\Repositories\CustomCupRoundRepository;

class CustomCupRoundService
{
    protected $repository;

    public function __construct(CustomCupRoundRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($customCup, $data)
    {
        return $this->repository->create($customCup, $data);
    }
}
