<?php

namespace App\Services;

use App\Enums\EventsEnum;
use App\Enums\PositionsEnum;
use App\Repositories\PlayerRepository;

class PlayerService
{
    /**
     * The user repository instance.
     *
     * @var ClubRepository
     */
    protected $repository;

    /**
     * The image manager instance.
     *
     * @var ImageManager
     */
    protected $images;

    /**
     * @var packageService
     */
    protected $packageService;

    /**
     * Create a new service instance.
     *
     * @param ClubRepository $repository
     */
    public function __construct(PlayerRepository $repository, PackageService $packageService)
    {
        $this->repository = $repository;
        $this->packageService = $packageService;
    }

    public function create($player)
    {
        return $this->repository->create($player);
    }

    public function update($player, $data)
    {
        return $this->repository->update($player, $data);
    }

    public function getClubs()
    {
        return $this->repository->getClubs();
    }

    public function playerImageDestroy($player)
    {
        return $this->repository->playerImageDestroy($player);
    }

    public function getAllPlayers($division, $data, $type)
    {
        if ($type == 'excel') {
            $export = $this->repository->exporttopdf($division);
        } elseif ($type == 'pdf') {
            $export = $this->repository->exporttoexcel($division);
        }

        return $export;
    }

    public function exportPlayersApi($division, $type)
    {
        if ($type == 'excel') {
            $export = $this->repository->exporttoexcel($division, true);
        } elseif ($type == 'pdf') {
            $export = $this->repository->exporttopdf($division, true);
        }

        return $export;
    }

    public function getAllPositions($division)
    {
        $positions = ($division->playerPositionEnum())::toSelectArray();

        return $positions;
    }

    public function playerInitialCount($names)
    {
        return $this->repository->playerInitialCount($names);
    }

    public function historyDataWeb($plaerID)
    {
        $historyStats = $this->repository->historyData($plaerID);

        return $historyStats;
    }

    public function historyData($division, $plaerID)
    {
        $historyStats = $this->repository->historyData($plaerID);

        $historyData[] = [];

        $playerPositions = PositionsEnum::toSelectArray();
        $divisionService = app(DivisionService::class);
        $divisionPoints = $divisionService->getDivisionPoints($division, $playerPositions);
        $count = 0;
        foreach ($historyStats as $historyStatsKey => $historyStatsValue) {
            $goal = isset($divisionPoints[$historyStatsValue->position][EventsEnum::GOAL]) && $divisionPoints[$historyStatsValue->position][EventsEnum::GOAL] ? $divisionPoints[$historyStatsValue->position][EventsEnum::GOAL] : 0;

            $assist = isset($divisionPoints[$historyStatsValue->position][EventsEnum::ASSIST]) && $divisionPoints[$historyStatsValue->position][EventsEnum::ASSIST] ? $divisionPoints[$historyStatsValue->position][EventsEnum::ASSIST] : 0;

            $goalConceded = isset($divisionPoints[$historyStatsValue->position][EventsEnum::GOAL_CONCEDED]) && $divisionPoints[$historyStatsValue->position][EventsEnum::GOAL_CONCEDED] ? $divisionPoints[$historyStatsValue->position][EventsEnum::GOAL_CONCEDED] : 0;

            $cleanSheet = isset($divisionPoints[$historyStatsValue->position][EventsEnum::CLEAN_SHEET]) && $divisionPoints[$historyStatsValue->position][EventsEnum::CLEAN_SHEET] ? $divisionPoints[$historyStatsValue->position][EventsEnum::CLEAN_SHEET] : 0;

            $appearance = isset($divisionPoints[$historyStatsValue->position][EventsEnum::APPEARANCE]) && $divisionPoints[$historyStatsValue->position][EventsEnum::APPEARANCE] ? $divisionPoints[$historyStatsValue->position][EventsEnum::APPEARANCE] : 0;

            $historyData[$count]['name'] = $historyStatsValue->season->name;
            $historyData[$count]['played'] = $historyStatsValue->played;
            $historyData[$count]['appearance'] = $historyStatsValue->appearance;
            $historyData[$count]['goal'] = $historyStatsValue->goal;
            $historyData[$count]['assist'] = $historyStatsValue->assist;
            $historyData[$count]['clean_sheet'] = $historyStatsValue->clean_sheet;
            $historyData[$count]['goal_conceded'] = $historyStatsValue->goal_conceded;
            //  $historyData[$count]['total'] = $historyData[$count]['appearance'] + $historyData[$count]['goal'] + $historyData[$count]['assist'] + $historyData[$count]['clean_sheet'] + $historyData[$count]['goal_conceded'];
            $historyData[$count]['total'] = $historyData[$count]['goal'] * $goal + $historyData[$count]['assist'] * $assist + $historyData[$count]['clean_sheet'] * $cleanSheet + $historyData[$count]['goal_conceded'] * $goalConceded + $historyData[$count]['appearance'] * $appearance;
            $count++;
        }
        if (count($historyStats) > 0) {
            return $historyData;
        }

        return  $historyStats;
    }

    public function getPlayerDetails($player_id)
    {
        return $this->repository->getPlayerDetails($player_id);
    }
}
