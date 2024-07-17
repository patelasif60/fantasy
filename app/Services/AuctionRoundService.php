<?php

namespace App\Services;

use App\Repositories\AuctionRoundRepository;

class AuctionRoundService
{
    /**
     * The AuctionRoundRepository repository instance.
     *
     * @var AuctionRoundRepository
     */
    protected $repository;

    public function __construct(AuctionRoundRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getActiveRound($division)
    {
        return $this->repository->getActiveRound($division);
    }

    public function getEndRound($division)
    {
        return $this->repository->getEndRound($division);
    }

    public function getEndRounds($division)
    {
        return $this->repository->getEndRounds($division);
    }

    public function getFutureActiveRound($division)
    {
        return $this->repository->getFutureActiveRound($division);
    }

    public function createFromLastRound($endRound)
    {
        return $this->repository->createFromLastRound($endRound);
    }

    public function getRound($division)
    {
        $round = $this->getActiveRound($division);

        if (! $round) {
            $round = $this->getFutureActiveRound($division);
        }

        return $round;
    }

    public function create($division, $data)
    {
        return $this->repository->createFromLastRound($division, $data);
    }

    public function getNextRoundCount($division)
    {
        return $this->repository->getNextRoundCount($division);
    }
}
