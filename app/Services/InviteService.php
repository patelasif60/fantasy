<?php

namespace App\Services;

use App\Repositories\InviteRepository;

class InviteService
{
    /**
     * The invite league repository instance.
     *
     * @var InviteRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param InviteRepository $repository
     */
    public function __construct(InviteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function invitation($division)
    {
        return $this->repository->invitation($division);
    }

    public function sendInvitations($data, $division)
    {
        return $this->repository->sendInvitations($data, $division);
    }

    public function getDivisionByInviteCode($code)
    {
        return $this->repository->getDivisionByInviteCode($code);
    }
}
