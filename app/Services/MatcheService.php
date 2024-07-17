<?php

namespace App\Services;

use App\Repositories\MatcheRepository;

class MatcheService
{
    protected $repository;

    public function __construct(MatcheRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getGameWeekMatches($gameWeek, $division)
    {
        return $this->repository->getGameWeekMatches($gameWeek, $division);
    }

    public function getMatchePlayers($gameWeek)
    {
        return $this->repository->getMatchePlayers($gameWeek);
    }

    public function getAssistPlayers($gameWeek)
    {
        return $this->repository->getAssistPlayers($gameWeek);
    }

    public function gameWeekFixtureStats($division, $gameWeek, $fixture)
    {
        return $this->repository->gameWeekFixtureStats($division, $gameWeek, $fixture);
    }
}
