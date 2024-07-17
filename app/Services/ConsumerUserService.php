<?php

namespace App\Services;

use App\Mail\Auth\RegisterEmail;
use App\Repositories\ConsumerRepository;
use App\Repositories\ConsumerUserRepository;
use Intervention\Image\ImageManager;
use Mail;

class ConsumerUserService
{
    /**
     * The consumer repository instance.
     *
     * @var ConsumerRepository
     */
    protected $repository;

    /**
     * The user repository instance.
     *
     * @var ConsumerUserRepository
     */
    protected $ConsumerUserRepository;

    /**
     * The image manager instance.
     *
     * @var ImageManager
     */
    protected $images;

    /**
     * Create a new service instance.
     *
     * @param ConsumerRepository $repository
     */
    public function __construct(ConsumerRepository $repository, ConsumerUserRepository $ConsumerUserRepository, ImageManager $images)
    {
        $this->repository = $repository;
        $this->ConsumerUserRepository = $ConsumerUserRepository;
        $this->images = $images;
    }

    public function create($data)
    {
        //Create user details
        $user = $this->ConsumerUserRepository->create($data);

        //Create consumer details

        $consumer = $this->repository->create($user, $data);

        //Register mail send

        // $mail = Mail::to($data['email'])->send(new RegisterEmail());

        return $consumer;
    }

    public function update($user, $data)
    {
        //Update user details
        $this->ConsumerUserRepository->update($user, $data);

        //Update consumer details
        return $this->repository->update($user->consumer, $data);
    }

    public function avatarDestroy($consumer)
    {
        return $this->repository->avatarDestroy($consumer);
    }
}
