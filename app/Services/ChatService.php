<?php

namespace App\Services;

use App\Jobs\MessagePushNotifications;
use App\Repositories\ChatRepository;

class ChatService
{
    /**
     * The chat repository instance.
     *
     * @var ChatRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param ChatRepository $repository
     */
    public function __construct(ChatRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create($division, $user, $data)
    {
        $consumerId = $data['consumer_id'];
        $divisionManagers = $division->divisionTeams->pluck('manager_id')->unique()->reject(function($item) use($consumerId) {
            return $item == $consumerId;
        });

        $chat = $this->repository->create($division, $divisionManagers, $data);
        MessagePushNotifications::dispatch($division, $user, $divisionManagers, $chat);

        return $chat;
    }

    public function getMessages($division, $consumer, $noOfRecords = 100)
    {
        return $this->repository->getMessages($division, $consumer, $noOfRecords);
    }

    public function getUnreadMessageCount($division, $consumer)
    {
        return $this->repository->getUnreadMessageCount($division, $consumer);
    }

    public function updateUnreadMessage($division, $consumer, $data = null)
    {
        return $this->repository->updateUnreadMessage($division, $consumer, $data);
    }

    public function delete($division, $chat)
    {
        return $this->repository->delete($division, $chat);
    }
}
