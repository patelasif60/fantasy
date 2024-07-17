<?php

namespace App\Services;

use App\Enums\EventsEnum;
use App\Enums\PositionsEnum;
use App\Repositories\LiveOnlineAuctionRepository;
use Illuminate\Support\Arr;

class LiveOnlineAuctionService
{
    protected $repository;

    protected $packageService;

    public function __construct(LiveOnlineAuctionRepository $repository, PackageService $packageService)
    {
        $this->repository = $repository;
        $this->packageService = $packageService;
    }

    public function getTeamManagers($request, $division, $isMobile)
    {
        $allData = $this->repository->getTeamManagers($request, $division);

        $data = $request->all();

        if (Arr::has($data, 'position') && Arr::get($data, 'position')) {
            $data['position'] = $division->getPositionFullName($data['position']);
        }

        $team = null;

        $players = $this->repository->getPlayers($division, $team, $data, $isMobile);
        $playersStats = $this->repository->getPlayersStats($players->pluck('playerId'));
        $positionOrder = $division->getPositionOrder();

        $division->load('package.packagePoints');
        $playerPositions = PositionsEnum::toSelectArray();

        $packagePointCalculation = $this->packageService->getPackagePoints($division->package, $playerPositions);

        $players->map(function ($item, $key) use ($packagePointCalculation, $team, $division, $positionOrder,$playersStats, $isMobile) {
            $pos = player_position_short($item->position);

            $goal = isset($packagePointCalculation[$pos][EventsEnum::GOAL]) && $packagePointCalculation[$pos][EventsEnum::GOAL] ? $packagePointCalculation[$pos][EventsEnum::GOAL] : 0;
            $assist = isset($packagePointCalculation[$pos][EventsEnum::ASSIST]) && $packagePointCalculation[$pos][EventsEnum::ASSIST] ? $packagePointCalculation[$pos][EventsEnum::ASSIST] : 0;
            $goalConceded = isset($packagePointCalculation[$pos][EventsEnum::GOAL_CONCEDED]) && $packagePointCalculation[$pos][EventsEnum::GOAL_CONCEDED] ? $packagePointCalculation[$pos][EventsEnum::GOAL_CONCEDED] : 0;
            $cleanSheet = isset($packagePointCalculation[$pos][EventsEnum::CLEAN_SHEET]) && $packagePointCalculation[$pos][EventsEnum::CLEAN_SHEET] ? $packagePointCalculation[$pos][EventsEnum::CLEAN_SHEET] : 0;
            $appearance = isset($packagePointCalculation[$pos][EventsEnum::APPEARANCE]) && $packagePointCalculation[$pos][EventsEnum::APPEARANCE] ? $packagePointCalculation[$pos][EventsEnum::APPEARANCE] : 0;
            $clubWin = isset($packagePointCalculation[$pos][EventsEnum::CLUB_WIN]) && $packagePointCalculation[$pos][EventsEnum::CLUB_WIN] ? $packagePointCalculation[$pos][EventsEnum::CLUB_WIN] : 0;
            $redCard = isset($packagePointCalculation[$pos][EventsEnum::RED_CARD]) && $packagePointCalculation[$pos][EventsEnum::RED_CARD] ? $packagePointCalculation[$pos][EventsEnum::RED_CARD] : 0;
            $yellowCard = isset($packagePointCalculation[$pos][EventsEnum::YELLOW_CARD]) && $packagePointCalculation[$pos][EventsEnum::YELLOW_CARD] ? $packagePointCalculation[$pos][EventsEnum::YELLOW_CARD] : 0;
            $ownGoal = isset($packagePointCalculation[$pos][EventsEnum::OWN_GOAL]) && $packagePointCalculation[$pos][EventsEnum::OWN_GOAL] ? $packagePointCalculation[$pos][EventsEnum::OWN_GOAL] : 0;
            $penaltyMissed = isset($packagePointCalculation[$pos][EventsEnum::PENALTY_MISSED]) && $packagePointCalculation[$pos][EventsEnum::PENALTY_MISSED] ? $packagePointCalculation[$pos][EventsEnum::PENALTY_MISSED] : 0;
            $penaltySave = isset($packagePointCalculation[$pos][EventsEnum::PENALTY_SAVE]) && $packagePointCalculation[$pos][EventsEnum::PENALTY_SAVE] ? $packagePointCalculation[$pos][EventsEnum::PENALTY_SAVE] : 0;
            $goalkeeperSave = isset($packagePointCalculation[$pos][EventsEnum::GOALKEEPER_SAVE_X5]) && $packagePointCalculation[$pos][EventsEnum::GOALKEEPER_SAVE_X5] ? $packagePointCalculation[$pos][EventsEnum::GOALKEEPER_SAVE_X5] : 0;

            $item->total_points = 0;
            $item->total_game_played = 0;
            $stats = $playersStats->where('playerId', $item->playerId)->first();
            if ($stats) {
                $total = 0;
                $total += $goal * $stats->total_goal;
                $total += $assist * $stats->total_assist;
                $total += $goalConceded * $stats->total_goal_against;
                $total += $cleanSheet * $stats->total_clean_sheet;
                $total += $appearance * $stats->total_game_played;
                $total += $clubWin * $stats->total_club_win;
                $total += $yellowCard * $stats->total_yellow_card;
                $total += $redCard * $stats->total_red_card;
                $total += $ownGoal * $stats->total_own_goal;
                $total += $penaltyMissed * $stats->total_penalty_missed;
                $total += $penaltySave * $stats->total_penalty_saved;
                $total += $goalkeeperSave * $stats->total_goalkeeper_save;

                $item->total_points = $total;
                $item->total_game_played = $stats->total_game_played;
            }

            $pos = $division->getPositionShortCode($pos);

            if ($isMobile) {
                $item->tshirt = player_tshirt($item->shortCode, $pos);
            }

            $playerName = get_player_name('fullName', $item->player_first_name, $item->player_last_name);
            $item->display_name = $playerName.' ('.$item->shortCode.') '.$pos;

            $item->position = $pos;
            $item->positionOrder = isset($positionOrder[$pos]) ? $positionOrder[$pos] : 0;
        });

        $allData['players'] = $players;

        return $allData;
    }

    public function searchPlayers($request, $division)
    {
        return $this->repository->searchPlayers($request, $division);
    }

    public function getPlayers($request, $division)
    {
        return $this->repository->getPlayers($request, $division);
    }

    public function playerSold($request, $division)
    {
        return $this->repository->playerSold($request, $division);
    }

    public function deleteSoldPlayer($request, $division)
    {
        return $this->repository->deleteSoldPlayer($request, $division);
    }

    public function updateSoldPlayer($request, $division)
    {
        return $this->repository->updateSoldPlayer($request, $division);
    }

    public function getSoldPlayersOfTeam($request, $division, $team)
    {
        return $this->repository->getSoldPlayersOfTeam($request, $division, $team);
    }

    public function getTeamPlayerCountForClub($request, $division, $club, $team)
    {
        return $this->repository->getTeamPlayerCountForClub($request, $division, $club, $team);
    }

    public function endLonAuction($division)
    {
        return $this->repository->endLonAuction($division);
    }
}
