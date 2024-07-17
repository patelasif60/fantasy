<?php

namespace App\Services;

use App\Repositories\CustomCupRoundGameweekRepository;

class CustomCupRoundGameweekService
{
    protected $repository;

    public function __construct(CustomCupRoundGameweekRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($round, $data)
    {
        $customCup = $this->repository->create($round, $data);
    }
}
