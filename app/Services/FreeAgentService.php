<?php

namespace App\Services;

use App\Repositories\FreeAgentRepository;

class FreeAgentService
{
    /**
     * The user repository instance.
     *
     * @var FreeAgentRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param FreeAgentRepository $repository
     */
    public function __construct(FreeAgentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllFreeAgents($division, $data, $type)
    {
        if ($type == 'excel') {
            $export = $this->repository->exporttoexcel($division);
        } elseif ($type == 'pdf') {
            $export = $this->repository->exporttopdf($division);
            
        }

        return $export;
    }

    public function exportPlayersApi($division, $type)
    {
        if ($type == 'excel') {
            $export = $this->repository->exporttoexcel($division, true);
        } elseif ($type == 'pdf') {
            $export = $this->repository->exporttopdf($division, true);
        }

        return $export;
    }
}
