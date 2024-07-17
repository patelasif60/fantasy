<?php

namespace App\Services;

use App\Enums\EuropeanPhasesNameEnum;
use App\Repositories\EuropeanPhaseRepository;

class EuropeanPhaseService
{
    /**
     * The european phase repository instance.
     *
     * @var EuropeanPhaseRepository
     */
    protected $repository;

    /**
     * Create a new service instance.
     *
     * @param EuropeanPhaseRepository $repository
     */
    public function __construct(EuropeanPhaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createEuropaLeaguePhase($gameweek, $name)
    {
        return $this->repository->create(
            $gameweek,
            EuropeanPhasesNameEnum::EUROPA_LEAGUE,
            $name
        );
    }

    public function createChampionsLeaguePhase($gameweek, $name)
    {
        return $this->repository->create(
            $gameweek,
            EuropeanPhasesNameEnum::CHAMPIONS_LEAGUE,
            $name
        );
    }

    public function update($europeanCompetitions, $name)
    {
        return $this->repository->update($europeanCompetitions, $name);
    }
}
