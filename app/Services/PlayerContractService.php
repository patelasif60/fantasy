<?php

namespace App\Services;

use App\Repositories\PlayerContractRepository;

class PlayerContractService
{
    /**
     * The player contract repository instance.
     *
     * @var PlayerContractRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param PlayerContractRepository $repository
     */
    public function __construct(PlayerContractRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($playerContract)
    {
        return $this->repository->create($playerContract);
    }

    public function update($playerContract, $data)
    {
        return $this->repository->update($playerContract, $data);
    }
}
