<?php

namespace App\Services;

use App\Jobs\SendSupersubsConfirmationEmail;
use App\Repositories\SuperSubsRepository;
use App\Repositories\TeamLineupRepository;

class TeamLineupService
{
    /**
     * The PointAdjustment repository instance.
     *
     * @var TeamLineupRepository
     */
    protected $repository;
    protected $superSubsRepository;

    /**
     * Create a new service instance.
     *
     * @param TeamLineupRepository $repository
     */
    public function __construct(TeamLineupRepository $repository, SuperSubsRepository $superSubsRepository)
    {
        $this->repository = $repository;
        $this->superSubsRepository = $superSubsRepository;
    }

    public function getLineupData($division, $team)
    {
        return $this->repository->getLineupData($division, $team);
    }

    public function getPlayerStats($division, $team)
    {
        return $this->repository->getPlayerStats($division, $team);
    }

    public function getPlayerStatsSold($division, $team)
    {
        return $this->repository->getPlayerStatsSold($division, $team);
    }

    public function swapPlayer($division, $team, $lineup_player, $sub_player, $formation)
    {
        return $this->repository->swapPlayer($division, $team, $lineup_player, $sub_player, $formation);
    }

    public function getTeamFixtures($team)
    {
        return $this->superSubsRepository->getLineupData($team);
    }

    public function getPlayersForFixture($teamId, $date)
    {
        return $this->superSubsRepository->getLineupData($teamId, $date);
    }

    public function getPlayerStatsBySeason($team, $player, $season)
    {
        return $this->repository->getPlayerStatsBySeason($team, $player, $season);
    }

    public function getPlayerStatsBySeasonSingle($division, $player, $seasonId)
    {
        return $this->repository->getPlayerStatsBySeasonSingle($division, $player, $seasonId);
    }

    public function checkSuperSubData($team)
    {
        return $this->superSubsRepository->checkSuperSubData($team);
    }

    public function checkTeamNextFixtureUpdatedData($data)
    {
        return $this->repository->checkTeamNextFixtureUpdatedData($data);
    }

    public function saveSuperSubData($data)
    {
        return $this->superSubsRepository->saveSuperSubData($data);
    }

    public function sendConfirmationEmails($team)
    {
        $data = [];
        $teamFixtures = $this->repository->getTeamFixturesForSupersubs($team);
        if (! $teamFixtures) {
            return ['status' => 'error', 'message' => 'You do not currently have any Supersubs set'];
        }
        foreach ($teamFixtures['futureFixturesDates'] as $key => $value) {
            $superSubs = $this->superSubsRepository->getSupersubs($team->id, $key);
            if ($superSubs) {
                $players = $this->superSubsRepository->getLineupData($team->id, $key, true);
            } else {
                $division = $team->teamDivision->first();
                $players = $this->repository->getLineupData($division,$team);
            }
            $data['fixtures'][$value['date_time']] = $players;
        }
        $data['currentDateTime'] = carbon_format_to_datetime_for_fixture(now());
        if ($data) {
            SendSupersubsConfirmationEmail::dispatch($team, $data);

            return ['status' => 'success', 'message' => 'Supersubs confirmation email sent'];
        }

        return false;
    }

    public function deleteSuperSubData($data)
    {
        return $this->superSubsRepository->deleteSuperSubData($data);
    }

    public function deleteAllSuperSubData($data)
    {
        return $this->superSubsRepository->deleteAllSuperSubData($data);
    }

    public function getTeamSuperSubFixtures($data)
    {
        return $this->repository->getTeamSuperSubFixtures($data);
    }

    public function getSupersubGuideCounter()
    {
        return $this->repository->getSupersubGuideCounter();
    }

    public function getTeamPlayersMoreStats($division, $team, $conditions)
    {
        return $this->repository->getTeamPlayersMoreStats($division, $team, $conditions);
    }
}
