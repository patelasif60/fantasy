<?php

namespace App\Services;

use App\Events\NewAdminUserInvited;
use App\Repositories\AdminUserRepository;

class AdminUserService
{
    /**
     * The user repository instance.
     *
     * @var UserRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param UserRepository $repository
     */
    public function __construct(AdminUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function invite($data)
    {
        // Create the user record
        $user = $this->repository->create($data);

        // Create invite
        $invite = $this->repository->invite($user);

        // Fire off the event
        event(new NewAdminUserInvited($user));

        return $user;
    }

    public function update($user, $data)
    {
        return $this->repository->update($user, $data);
    }
}
