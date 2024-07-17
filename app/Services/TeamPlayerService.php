<?php

namespace App\Services;

use App\Repositories\TeamPlayerRepository;

class TeamPlayerService
{
    /**
     * The TeamPlayer repository instance.
     *
     * @var TransferRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param TeamPlayer $repository
     */
    public function __construct(TeamPlayerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getContracts($team, $player)
    {
        return $this->repository->listContracts($team->id, $player->id);
    }

    public function store($data, $team, $player)
    {
        return $this->repository->store($data, $team->id, $player->id);
    }
}
