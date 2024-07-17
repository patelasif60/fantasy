<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Repositories\FixtureStatsRepository;
use App\Repositories\TeamPlayerPointsRepository;

class TeamPlayerPointsService
{
    /**
     * The TeamPlayerPointsRepository repository instance.
     *
     * @var TeamPlayerPointsRepository
     */
    protected $repository;
    /**
     * The FixtureStats repository instance.
     *
     * @var FixtureStatsRepository
     */
    protected $fixtureStatsRepository;

    /**
     * Create a new service instance.
     *
     * @param TeamPlayerPointsRepository $repository
     * @param FixtureStatsRepository $fixtureStatsRepository
     */
    public function __construct(TeamPlayerPointsRepository $repository, FixtureStatsRepository $fixtureStatsRepository)
    {
        $this->repository = $repository;
        $this->fixtureStatsRepository = $fixtureStatsRepository;
    }

    public function recalculate($data, $team, $player)
    {
        $start_date = $data['start_date'];
        $end_date = Arr::get($data,'end_date', []);
        $is_active = Arr::get($data,'is_active', []);
        $recalculate = 0;
        $team_id = is_numeric($team) ? $team : $team->id;
        $player_id = is_numeric($player) ? $player : $player->id;

        foreach ($start_date as $key => $date) {
            $dateArr = [];
            $dateArr['start_date'] = Carbon::createFromFormat(config('fantasy.time.format'), $date)->format(config('fantasy.db.datetime.format'));
            if (Arr::get($end_date,$key)) {
                $dateArr['end_date'] = Carbon::createFromFormat(config('fantasy.time.format'), $end_date[$key])->format(config('fantasy.db.datetime.format'));
            }

            $stats = $this->fixtureStatsRepository->getByPlayerContracts($player_id, $dateArr);
            $recalculated = $this->repository->recalculate($team_id, $player_id, $stats, Arr::get($is_active, $key, 0));
            if ($recalculated) {
                $recalculate++;
            }
        }

        return $recalculate;
    }

    public function updateLivePoints($fixtureStat, $team_id)
    {
        return $this->repository->updateLivePoints($fixtureStat, $team_id);
    }

    public function updateRankingPoints($fixtureStat, $team_id)
    {
        return $this->repository->updateRankingPoints($fixtureStat, $team_id);
    }

    public function updateStatsPoints($fixtureStat, $team_id)
    {
        return $this->repository->updateStatsPoints($fixtureStat, $team_id);
    }

    public function updateStatsRankingPoints($fixtureStat, $team_id)
    {
        return $this->repository->updateStatsRankingPoints($fixtureStat, $team_id);
    }
}
