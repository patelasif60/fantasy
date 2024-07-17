<?php

namespace App\Services;

use Illuminate\Support\Arr;
use App\Repositories\ConsumerRepository;
use App\Repositories\UserRepository;

class UserService
{
    /**
     * The user repository instance.
     *
     * @var UserRepository
     */
    protected $repository;

    /**
     * The consumer repository instance.
     *
     * @var ConsumerRepository
     */
    protected $consumer;

    /**
     * Create a new service instance.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository, ConsumerRepository $consumer)
    {
        $this->repository = $repository;
        $this->consumer = $consumer;
    }

    public function update($user, $data)
    {
        return $this->repository->update($user, $data);
    }

    public function incomplete_update($user, $data)
    {
        $this->repository->update($user, $data);

        if ($user->consumer) {
            $this->consumer->updateBasicDetails($user->consumer, $data);
        } else {
            $this->consumer->storeBasicDetails($user, $data);
        }

        return $user;
    }

    public function saveAccountSettings($data, $user)
    {
        //Update User Details
        $this->repository->update($user, $data);

        //Update Consumer Details
        $data['has_games_news'] = Arr::has($data, 'has_games_news') && (Arr::get($data, 'has_games_news') == true) ? true : false;
        $data['has_third_parities'] = Arr::has($data, 'has_third_parities') && (Arr::get($data, 'has_third_parities') == true) ? true : false;
        $data['dob'] = Arr::has($data, 'dob') && Arr::get($data, 'dob') ? carbon_create_from_date($data['dob']) : null;
        $consumer = $this->consumer->update($user->consumer, $data);

        return $consumer;
    }

    public function saveUserRegistrationId($user, $data)
    {
        return $this->repository->saveUserRegistrationId($user, $data);
    }

    public function createConsumer($user, $data)
    {
        $data['has_games_news'] = isset($data['has_games_news']) ? true : false;
        $data['has_third_parities'] = isset($data['has_third_parities']) ? true : false;
        $this->consumer->createConsumer($user, $data);

        return $user;
    }

    public function createConsumerWithDetails($user, $data)
    {
        $data['has_games_news'] = isset($data['has_games_news']) ? true : false;
        $data['has_third_parities'] = isset($data['has_third_parities']) ? true : false;
        $this->consumer->create($user, $data);

        return $user;
    }

    public function getActiveAdmins()
    {
        return $this->repository->getActiveAdmins();
    }
}
