<?php

namespace App\Services;

use App\Repositories\CustomCupRepository;
use App\Repositories\DivisionRepository;
use Illuminate\Support\Arr;

class CustomCupService
{
    /**
     * The procup phase repository instance.
     *
     * @var repository
     */
    protected $repository;

    protected $divisionRepository;

    protected $customCupTeamService;

    protected $customCupRoundService;

    protected $customCupRoundGameweekService;

    public function __construct(CustomCupRepository $repository, DivisionRepository $divisionRepository, CustomCupTeamService $customCupTeamService, CustomCupRoundService $customCupRoundService, CustomCupRoundGameweekService $customCupRoundGameweekService)
    {
        $this->repository = $repository;
        $this->divisionRepository = $divisionRepository;
        $this->customCupTeamService = $customCupTeamService;
        $this->customCupRoundService = $customCupRoundService;
        $this->customCupRoundGameweekService = $customCupRoundGameweekService;
    }

    public function create($division, $data)
    {
        $customCup = $this->repository->create($division, $data);

        if ($customCup) {
            $byeTeams = Arr::has($data, 'bye_teams') && (! Arr::has($data, 'is_bye_random') || Arr::get($data, 'is_bye_random') == '1') ? $data['bye_teams'] : [];

            foreach ($data['teams'] as $value) {
                $team = [];
                $team['team_id'] = $value;
                $team['is_bye'] = in_array($value, $byeTeams) ? true : false;

                $this->customCupTeamService->create($customCup, $team);
            }

            foreach ($data['rounds'] as $key => $gameweeks) {
                $round = $this->customCupRoundService->create($customCup, $key);

                foreach ($gameweeks as $value) {
                    $this->customCupRoundGameweekService->create($round, $value);
                }
            }
        }

        return $customCup;
    }

    public function update($division, $customCup, $data)
    {
        $customCup = $this->repository->update($customCup, $data);

        if ($customCup) {
            $byeTeams = Arr::has($data, 'bye_teams') && (! Arr::has($data, 'is_bye_random') || Arr::get($data, 'is_bye_random') == '1') ? $data['bye_teams'] : [];

            $customCup->teams()->delete();

            foreach ($data['teams'] as $value) {
                $team = [];
                $team['team_id'] = $value;
                $team['is_bye'] = in_array($value, $byeTeams) ? true : false;
                $this->customCupTeamService->create($customCup, $team);
            }

            $customCup->rounds()->delete();

            foreach ($data['rounds'] as $key => $gameweeks) {
                $round = $this->customCupRoundService->create($customCup, $key);

                foreach ($gameweeks as $value) {
                    $this->customCupRoundGameweekService->create($round, $value);
                }
            }
        }

        return $customCup;
    }
}
