<?php

namespace App\Services;

use App\Repositories\CustomCupTeamRepository;

class CustomCupTeamService
{
    protected $repository;

    public function __construct(CustomCupTeamRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($customCup, $data)
    {
        return $this->repository->create($customCup, $data);
    }
}
