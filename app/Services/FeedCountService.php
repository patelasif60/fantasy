<?php

namespace App\Services;

use App\Repositories\FeedCountRepository;
use GuzzleHttp\Client;

class FeedCountService
{
    /**
     * The user repository instance.
     *
     * @var FeedCountRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param FeedCountRepository $repository
     */
    public function __construct(FeedCountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getUnreadCount($consumer)
    {
        $count = 0;
        $dbCount = $this->repository->getUnreadCount($consumer);
        $feedCount = $this->getFeedCount();

        if ($feedCount > $dbCount) {
            $count = $feedCount - $dbCount;
        }

        return $count;
    }

    public function getFeedCount()
    {
        try {
            $client = new Client();   
            $response = $client->get(config('fantasy.wordpress_url').'/posts', ['per_page' => 1]);
            if ($response->getBody()) {
                $response = json_decode($response->getBody());
                if (isset($response->found) && $response->found > 0) {
                    return $response->found;
                }
            }

        } catch (Throwable $e) {
            return 0;
        }
    }

    public function updateUnreadFeeds($consumer)
    {
        $feedCount = $this->getFeedCount();

        return $this->repository->update($consumer, $feedCount);
    }
}
