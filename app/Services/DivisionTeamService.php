<?php

namespace App\Services;

use App\Models\CmdSetting;
use App\Repositories\DivisionTeamRepository;
use App\Repositories\FixtureStatsRepository;
use App\Repositories\TeamPlayerPointsRepository;
use App\Repositories\TeamPlayerRepository;

class DivisionTeamService
{
    /**
     * The DivisionTeam  repository instance.
     *
     * @var DivisionTeam Repository
     */
    protected $repository;

    /**
     * The TeamPlayer  repository instance.
     *
     * @var TeamPlayerRepository
     */
    protected $teamPlayerRepository;

    /**
     * The TeamPlayerPoints  repository instance.
     *
     * @var TeamPlayerPointsRepository
     */
    protected $teamPlayerPointsRepository;

    /**
     * The FixtureStats  repository instance.
     *
     * @var FixtureStatsRepository
     */
    protected $fixtureStatsRepository;

    /**
     * Create a new service instance.
     *
     * @param DivisionTeamRepository $repository
     * @param TeamPlayerRepository $teamPlayerRepository
     * @param FixtureStatsRepository $fixtureStatsRepository
     * @param TeamPlayerPointsRepository $teamPlayerPointsRepository
     */
    public function __construct(DivisionTeamRepository $repository, TeamPlayerRepository $teamPlayerRepository, FixtureStatsRepository $fixtureStatsRepository, TeamPlayerPointsRepository $teamPlayerPointsRepository)
    {
        $this->repository = $repository;
        $this->teamPlayerRepository = $teamPlayerRepository;
        $this->fixtureStatsRepository = $fixtureStatsRepository;
        $this->teamPlayerPointsRepository = $teamPlayerPointsRepository;
    }

    public function create($divisionTeam)
    {
        return $this->repository->create($divisionTeam);
    }

    public function update($divisionTeam, $data)
    {
        return $this->repository->update($divisionTeam, $data);
    }

    public function getTeams($team_id = null)
    {
        return $this->repository->getTeams($team_id);
    }

    public function getSeasons()
    {
        return $this->repository->getSeasons();
    }

    public function recalculatePoints($division_id)
    {
        unset($command);
        $command['type'] = 'recalculate_points_for_league';
        $command['command'] = 'recalculate:league-points';
        $command['payload'] = json_encode(['division' => $division_id, 'email' => auth()->user()->email ]);

        $response = CmdSetting::create($command);


        // $teamPlayerContracts = $this->teamPlayerRepository->getCurrentContractForTeam($this->repository->getDivisionTeams($division_id)->pluck('team_id'));

        // $missedContracts = $this->teamPlayerRepository->getMissedPlayerContracts($teamPlayerContracts);
        // $recalculatePoints = 0;

        // foreach ($missedContracts as $contract) {
        //     $stats = $this->fixtureStatsRepository->getByPlayerContracts($contract['player_id'], ['start_date' => $contract['start_date'], 'end_date' => $contract['end_date']]);
        //     if ($stats->count() > 0) {
        //         $recalculatePoints += $this->teamPlayerPointsRepository->recalculate($contract['team_id'], $contract['player_id'], $stats);
        //     }
        // }

        // return $recalculatePoints;
    }
}
