<?php

namespace App\Services;

use App\Enums\EventsEnum;
use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Enums\PositionsEnum;
use App\Enums\TransferTypeEnum;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use App\Repositories\ClubRepository;
use App\Repositories\PlayerContractRepository;
use App\Repositories\TeamPlayerRepository;
use App\Repositories\TransferRepository;
use Illuminate\Support\Arr;

class TransferService
{
    /**
     * The transfer repository instance.
     *
     * @var TransferRepository
     */
    protected $repository;

    /**
     * The TeamPlayerContract Repository instance.
     *
     * @var TeamPlayerRepository
     */
    protected $teamPlayerRepository;

    /**
     * The PlayerContractRepository Repository instance.
     *
     * @var PlayerContractRepository
     */
    protected $playerContractRepository;

    /**
     * Create a new service instance.
     *
     * @param SeasonRepository $repository TeamPlayerRepository $teamPlayerRepository PlayerContractRepository $playerContractRepository
     */

    /**
     * @var validateTransferFormationService
     */
    protected $validateTransferFormationService;

    public function __construct(TransferRepository $repository, TeamPlayerRepository $teamPlayerRepository, PlayerContractRepository $playerContractRepository, ValidateTransferFormationService $validateTransferFormationService, PackageService $packageService, ClubRepository $clubRepository)
    {
        $this->repository = $repository;
        $this->teamPlayerRepository = $teamPlayerRepository;
        $this->playerContractRepository = $playerContractRepository;
        $this->validateTransferFormationService = $validateTransferFormationService;
        $this->packageService = $packageService;
        $this->clubRepository = $clubRepository;
    }

    public function create($transfer)
    {
        if ($transfer['transfer_type'] != TransferTypeEnum::BUDGETCORRECTION) {
            $this->teamPlayerRepository->createContracts($transfer);
        }

        return $this->repository->create($transfer);
    }

    public function update($transfer, $data)
    {
        return $this->repository->update($transfer, $data);
    }

    public function getPlayersIn($team = null, $data = null)
    {
        return $this->playerContractRepository->getPlayerContractWithClub($team, $data);
    }

    public function getPlayersOut($team)
    {
        return $this->teamPlayerRepository->getPlayerTeamContractsWithClub($team);
    }

    public function swapPlayersContract($division, $data)
    {
        $this->teamPlayerRepository->swapPlayersContract($data);

        $auctionService = app(AuctionService::class);
        $teams = collect($data)->pluck('playerInTeam')->merge(collect($data)->pluck('playerOutTeam'))->unique();

        foreach ($teams as $id) {
            $team = Team::find($id);
            $mergeDefenders = $division->getOptionValue('merge_defenders');
            $availableFormations = $division->getOptionValue('available_formations');
            $activePlayers = $this->getActiveTeamPlayerPostions($team);
            if (! $this->validateTransferFormationService->checkPossibleFormation($availableFormations, $mergeDefenders, $activePlayers)) {
                $totalPlayers = TeamPlayerContract::where('team_id', $team->id)->whereNull('end_date')->select('player_id')->get()->pluck('player_id')->toArray();
                $this->teamPlayerRepository->updatePlayerData($totalPlayers, $team->id);
                $teamPlayers = $this->getTeamPlayerContracts($team);
                $teamPlayers->filter(function ($value, $key) use ($division) {
                    if ($division->getOptionValue('merge_defenders') == 'Yes') {
                        if ($value->position == AllPositionEnum::CENTREBACK || $value->position == AllPositionEnum::FULLBACK) {
                            return $value->setAttribute('position', AllPositionEnum::DEFENDER);
                        }
                    }

                    if ($value->position == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
                        return $value->setAttribute('position', AllPositionEnum::MIDFIELDER);
                    }
                });

                $auctionService->setTeamFormations($division, $teamPlayers->groupBy('position'));
            }
        }

        return true;
    }

    public function getDivisionPlayers($division)
    {
        return $this->teamPlayerRepository->getDivisionPlayers($division);
    }

    public function checkTransferPossible($data)
    {
        $teamTotalPlayers = [];
        foreach ($data as $key => $value) {
            $teamTotalPlayers[$value['playerOutTeam']][] = $value['playerOut'];
            $teamTotalPlayers[$value['playerInTeam']][] = $value['playerIn'];
        }

        $teams = collect($data)->groupBy('playerOutTeam');
        $swapOuts = collect($data)->groupBy('playerOutTeam');
        $swapIns = collect($data)->groupBy('playerInTeam');

        foreach ($swapOuts as $teamKey => $teamValue) {
            $playersOut = collect();
            $newPlayersIn = collect();
            $oldPlayersIn = collect();

            $playerOutBudget = 0;
            $playerInBudget = 0;

            foreach ($teamValue as $playerKey => $playerValue) {
                $playersOut->push($playerValue['playerOut']);
                $newPlayersIn->push($playerValue['playerIn']);

                $playerOutBudget += $playerValue['playerOutPrice'];
                $playerInBudget += $playerValue['playerInPrice'];
            }
            $chkPlayerInOutInTeam = $this->chkPlayerInOutInTeam($teamKey, $playersOut, $newPlayersIn);
            if (! $chkPlayerInOutInTeam) {
                return ['status'=> false, 'message' => 'NOT DONE - Please refresh for current line-ups'];
            }

            $possible = $this->checkTeamTransferPossible($playersOut, $newPlayersIn, $playerOutBudget, $playerInBudget, $teamKey, $teamTotalPlayers);
            if (! $possible['status']) {
                return ['status'=> false, 'message' => $possible['message']];
            }
        }

        foreach ($swapIns as $teamKey => $teamValue) {
            $playersOut = collect();
            $newPlayersIn = collect();
            $oldPlayersIn = collect();

            $playerOutBudget = 0;
            $playerInBudget = 0;

            foreach ($teamValue as $playerKey => $playerValue) {
                $playersOut->push($playerValue['playerIn']);
                $newPlayersIn->push($playerValue['playerOut']);

                $playerOutBudget += $playerValue['playerInPrice'];
                $playerInBudget += $playerValue['playerOutPrice'];
            }
            $chkPlayerInOutInTeam = $this->chkPlayerInOutInTeam($teamKey, $playersOut, $newPlayersIn);
            if (! $chkPlayerInOutInTeam) {
                return ['status'=> false, 'message' => 'NOT DONE - Please refresh for current line-ups'];
            }
            $possible = $this->checkTeamTransferPossible($playersOut, $newPlayersIn, $playerOutBudget, $playerInBudget, $teamKey, $teamTotalPlayers);
            if (! $possible['status']) {
                return ['status'=> false, 'message' => $possible['message']];
            }
        }

        return ['status'=> true, 'message' => 'successfull'];
    }

    public function checkTeamTransferPossible($playersOut, $newPlayersIn, $playerOutBudget, $playerInBudget, $teamKey, $teamTotalPlayers)
    {
        $oldPlayersIn = $this->teamPlayerRepository->getInPlayers($teamKey, $playersOut);
        $totalPlayers = $oldPlayersIn->merge($newPlayersIn);

        $players = $this->getPlayerPositions($totalPlayers);

        $teamBudget = $this->teamPlayerRepository->getTeamBudget($teamKey);
        $teamDivision = $this->teamPlayerRepository->getTeamDivision($teamKey);
        $mergeDefenders = $teamDivision->getOptionValue('merge_defenders');
        $availableFormations = $teamDivision->getOptionValue('available_formations');

        $teamQuota = $this->teamPlayerRepository->getTeam($teamKey);
        $season_free_agent_transfer_limit = $teamDivision->getOptionValue('season_free_agent_transfer_limit');
        if (($teamQuota->season_quota_used + count($teamTotalPlayers[$teamKey])) > $season_free_agent_transfer_limit) {
            return ['status'=> false, 'message' => trans('messages.transfer.seasons_quota.error')];
        }

        $monthly_free_agent_transfer_limit = $teamDivision->getOptionValue('monthly_free_agent_transfer_limit');
        if (($teamQuota->monthly_quota_used + count($teamTotalPlayers[$teamKey])) > $monthly_free_agent_transfer_limit) {
            return ['status'=> false, 'message' => trans('messages.transfer.monthly_quota.error')];
        }

        if (! $this->validateTransferFormationService->checkPossibleFormation($availableFormations, $mergeDefenders, $players)) {
            return ['status'=> false, 'message' => trans('messages.swap.formation.error')];
        }

        $currentBudget = $teamBudget + $playerOutBudget;

        if (($currentBudget < 0 || $playerInBudget < 0) || $currentBudget < $playerInBudget) {

            return ['status' => false, 'message' => trans('messages.swap.team_budget.error')];
        }

        $clubs = $this->teamPlayerRepository->getTeamClubsPlayer($teamKey, $totalPlayers);

        $newPlayersClub = $this->teamPlayerRepository->getPlayersClub($teamKey, $newPlayersIn);
        foreach ($newPlayersClub as $key => $value) {
            if (Arr::exists($clubs, $value)) {
                $clubs[$value] = $clubs[$value] + 1;
            }
        }

        $maxClubPlayer = $teamDivision->getOptionValue('default_max_player_each_club');
        foreach ($clubs as $clubKey => $clubValue) {
            if ($maxClubPlayer < $clubValue) {
                return ['status'=> false, 'message' => trans('messages.swap.club_quota.error')];
            }
        }

        return ['status'=> true, 'message' => 'successfull'];
    }

    public function getTeamTransferPlayersPositionWise($division, $team)
    {
        $teamPlayers = $this->repository->getTeamTransferPlayers($team);

        $teamPlayers = $teamPlayers->groupBy('position');
        if (! $teamPlayers->has(AllPositionEnum::GOALKEEPER)) {
            $teamPlayers->put(AllPositionEnum::GOALKEEPER, collect());
        }
        if (! $teamPlayers->has(AllPositionEnum::CENTREBACK)) {
            $teamPlayers->put(AllPositionEnum::CENTREBACK, collect());
        }
        if (! $teamPlayers->has(AllPositionEnum::FULLBACK)) {
            $teamPlayers->put(AllPositionEnum::FULLBACK, collect());
        }
        if ($division->getOptionValue('merge_defenders') == 'Yes') {
            $teamPlayers[AllPositionEnum::DEFENDER] = $teamPlayers[AllPositionEnum::FULLBACK]->concat($teamPlayers[AllPositionEnum::CENTREBACK]);
            $teamPlayers->forget(AllPositionEnum::FULLBACK);
            $teamPlayers->forget(AllPositionEnum::CENTREBACK);
        }
        if (! $teamPlayers->has(AllPositionEnum::MIDFIELDER)) {
            $teamPlayers->put(AllPositionEnum::MIDFIELDER, collect());
        }
        if (! $teamPlayers->has(AllPositionEnum::DEFENSIVE_MIDFIELDER)) {
            $teamPlayers->put(AllPositionEnum::DEFENSIVE_MIDFIELDER, collect());
        }
        if ($division->getOptionValue('defensive_midfields') == 'No') {
            $teamPlayers[AllPositionEnum::MIDFIELDER] = $teamPlayers[AllPositionEnum::MIDFIELDER]->concat($teamPlayers[AllPositionEnum::DEFENSIVE_MIDFIELDER]);
            $teamPlayers->forget(AllPositionEnum::DEFENSIVE_MIDFIELDER);
        }
        if (! $teamPlayers->has(AllPositionEnum::STRIKER)) {
            $teamPlayers->put(AllPositionEnum::STRIKER, collect());
        }
        $tempTeamPlayers[AllPositionEnum::GOALKEEPER] = $teamPlayers[AllPositionEnum::GOALKEEPER];
        if ($division->getOptionValue('merge_defenders') == 'Yes') {
            $tempTeamPlayers[AllPositionEnum::DEFENDER] = $teamPlayers[AllPositionEnum::DEFENDER];
        } else {
            $tempTeamPlayers[AllPositionEnum::FULLBACK] = $teamPlayers[AllPositionEnum::FULLBACK];
            $tempTeamPlayers[AllPositionEnum::CENTREBACK] = $teamPlayers[AllPositionEnum::CENTREBACK];
        }
        if ($division->getOptionValue('defensive_midfields') == 'Yes') {
            $tempTeamPlayers[AllPositionEnum::DEFENSIVE_MIDFIELDER] = $teamPlayers[AllPositionEnum::DEFENSIVE_MIDFIELDER];
        }
        $tempTeamPlayers[AllPositionEnum::MIDFIELDER] = $teamPlayers[AllPositionEnum::MIDFIELDER];
        $tempTeamPlayers[AllPositionEnum::STRIKER] = $teamPlayers[AllPositionEnum::STRIKER];

        return $tempTeamPlayers;
        $formatedPlayers = [];
        $playersCollection = collect($tempTeamPlayers)->map(function ($item, $key) use (&$formatedPlayers, $division) {
            $playerPositions = $item->map(function ($player) use ($division) {
                $pos = player_position_short($player->position);
                $player->position = $division->getPositionShortCode($pos);

                $player->tshirt = player_tshirt($player->short_code, $player->position);

                return $player;
            });

            $pos = $division->getPositionShortCode(player_position_short($key));

            return $formatedPlayers[$pos] = $playerPositions;
        });

        return $formatedPlayers;
    }

    public function getTransferPlayers($division, $team, $data)
    {
        $players = $this->repository->getTransferPlayers($division, $team, $data);
        $playersStats = $this->repository->getPlayersStats($players->pluck('id'));
        $positionOrder = $division->getPositionOrder();
        $playerPositions = PositionsEnum::toSelectArray();
        
        $divisionService = app(DivisionService::class);
        $divisionPoints = $divisionService->getDivisionPoints($division, $playerPositions);

        $players->each(function ($item, $key) use ($divisionPoints, $division, $positionOrder, $playersStats) {
            $position = player_position_short($item->position);

            $goal = isset($divisionPoints[$item->position][EventsEnum::GOAL]) && $divisionPoints[$item->position][EventsEnum::GOAL] ? $divisionPoints[$item->position][EventsEnum::GOAL] : 0;
            $assist = isset($divisionPoints[$item->position][EventsEnum::ASSIST]) && $divisionPoints[$item->position][EventsEnum::ASSIST] ? $divisionPoints[$item->position][EventsEnum::ASSIST] : 0;
            $goalConceded = isset($divisionPoints[$item->position][EventsEnum::GOAL_CONCEDED]) && $divisionPoints[$item->position][EventsEnum::GOAL_CONCEDED] ? $divisionPoints[$item->position][EventsEnum::GOAL_CONCEDED] : 0;
            $cleanSheet = isset($divisionPoints[$item->position][EventsEnum::CLEAN_SHEET]) && $divisionPoints[$item->position][EventsEnum::CLEAN_SHEET] ? $divisionPoints[$item->position][EventsEnum::CLEAN_SHEET] : 0;
            $appearance = isset($divisionPoints[$item->position][EventsEnum::APPEARANCE]) && $divisionPoints[$item->position][EventsEnum::APPEARANCE] ? $divisionPoints[$item->position][EventsEnum::APPEARANCE] : 0;
            $clubWin = isset($divisionPoints[$item->position][EventsEnum::CLUB_WIN]) && $divisionPoints[$item->position][EventsEnum::CLUB_WIN] ? $divisionPoints[$item->position][EventsEnum::CLUB_WIN] : 0;
            $yellowCard = isset($divisionPoints[$item->position][EventsEnum::YELLOW_CARD]) && $divisionPoints[$item->position][EventsEnum::YELLOW_CARD] ? $divisionPoints[$item->position][EventsEnum::YELLOW_CARD] : 0;
            $redCard = isset($divisionPoints[$item->position][EventsEnum::RED_CARD]) && $divisionPoints[$item->position][EventsEnum::RED_CARD] ? $divisionPoints[$item->position][EventsEnum::RED_CARD] : 0;
            $ownGoal = isset($divisionPoints[$item->position][EventsEnum::OWN_GOAL]) && $divisionPoints[$item->position][EventsEnum::OWN_GOAL] ? $divisionPoints[$item->position][EventsEnum::OWN_GOAL] : 0;
            $penaltyMissed = isset($divisionPoints[$item->position][EventsEnum::PENALTY_MISSED]) && $divisionPoints[$item->position][EventsEnum::PENALTY_MISSED] ? $divisionPoints[$item->position][EventsEnum::PENALTY_MISSED] : 0;
            $penaltySave = isset($divisionPoints[$item->position][EventsEnum::PENALTY_SAVE]) && $divisionPoints[$item->position][EventsEnum::PENALTY_SAVE] ? $divisionPoints[$item->position][EventsEnum::PENALTY_SAVE] : 0;
            $goalkeeperSave = isset($divisionPoints[$item->position][EventsEnum::GOALKEEPER_SAVE_X5]) && $divisionPoints[$item->position][EventsEnum::GOALKEEPER_SAVE_X5] ? $divisionPoints[$item->position][EventsEnum::GOALKEEPER_SAVE_X5] : 0;

            $stats = $playersStats->where('playerId', $item->id)->first();
            $item->total = 0;
            $item->total_game_played = 0;
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

                $item->total = $total;
                $item->total_game_played = $stats->total_game_played;
            }

            $position = $division->getPositionShortCode($position);
            $item->playerPositionShort = $position;
            $item->positionOrder = isset($positionOrder[$position]) ? $positionOrder[$position] : 0;
        });

        return $players;
    }

    public function getTeamDetails($division, $team)
    {
        $team->setAttribute('crest', $team->getCrestImageThumb());
        $team->setAttribute('defaultSquadSize', $division->getOptionValue('default_squad_size'));
        $team->setAttribute('team_players_count', $team->teamPlayers->count());
        $team->setAttribute('team_budget', $team->team_budget);
        unset($team['teamPlayers']);

        return $team;
    }

    public function getDivisionTeamsDetails($division)
    {
        $defaultSquadSize = $division->getOptionValue('default_squad_size');
        $divisionTeams = $this->repository->getDivisionTeamsDetails($division);

        return $divisionTeams->filter(function ($value, $key) use ($defaultSquadSize) {
            $value->setAttribute('crest', $value->getCrestImageThumb());
            $value->setAttribute('defaultSquadSize', $defaultSquadSize);
            $value->setAttribute('team_players_count', $value->transferBudget->count());
            unset($value['transferBudget']);

            return $value->setAttribute('defaultSquadSize', $defaultSquadSize);
        });
    }

    public function getClubs($where = [])
    {
        return $this->clubRepository->listWithShortCode();
    }

    public function getPositions($division)
    {
        return $position = ($division->playerPositionEnum())::toSelectArray();
    }

    public function getTeamPlayerPostions($team, $totalPlayers = [])
    {
        return $this->repository->getTeamPlayerPostions($team, $totalPlayers)->pluck('total', 'position')->toArray();
    }

    public function getTeamClubsPlayer($team)
    {
        //return $this->repository->getTeamClubsPlayer($team);
        return $this->repository->getTeamTransferPlayers($team);
    }

    public function getActiveTeamPlayerPostions($team, $totalPlayers = [])
    {
        return $this->repository->getActiveTeamPlayerPostions($team, $totalPlayers)->pluck('total', 'position')->toArray();
    }

    public function getActiveTeamPlayerPositionReport($team, $totalPlayers = [])
    {
        return $this->repository->getActiveTeamPlayerPositionReport($team, $totalPlayers)->pluck('total', 'position')->toArray();
    }

    public function getTeamPlayerContracts($team)
    {
        return $this->repository->getTeamPlayerContracts($team);
    }

    public function getTeamPlayers($division, $teamId)
    {
        return $this->teamPlayerRepository->getTeamPlayers($division, $teamId);
    }

    public function getPlayerPositions($totalPlayers = [])
    {
        return $this->teamPlayerRepository->getTeamPlayerPostions($totalPlayers)->pluck('total', 'position')->toArray();
    }

    public function getTransferPlayerOtherTeamCount($division, $transferPlayersArray)
    {
        return $this->repository->getTransferPlayerOtherTeamCount($division, $transferPlayersArray);
    }

    public function getTransferPlayerInTeamCount($team, $transferPlayersArray)
    {
        return $this->repository->getTransferPlayerInTeamCount($team, $transferPlayersArray);
    }

    public function chkPlayerInOutInTeam($teamKey, $playersOut, $newPlayersIn)
    {
        $playerOutTeamCheak = TeamPlayerContract::where('team_id', $teamKey)
                                        ->where('player_id', $playersOut)
                                        ->whereNull('end_date')
                                        ->count();
        if ($playerOutTeamCheak <= 0) {
            return false;
        }
        $playerInTeamCheak = TeamPlayerContract::where('team_id', $teamKey)
                                    ->where('player_id', $newPlayersIn)
                                    ->whereNull('end_date')
                                    ->count();
        if ($playerInTeamCheak > 0) {
            return false;
        }

        return true;
    }

    public function getPlayersForTransfers($boughtPlayerIds)
    {
        return $this->repository->getPlayersForTransfers($boughtPlayerIds);
    }

    public function subsValidation($division, $team, $lineup_player, $sub_player, $formation)
    {

        $checkAlraadyOnBench = TeamPlayerContract::where('team_id', $team->id)
                                        ->where('player_id', [$lineup_player])
                                        ->where('is_active', 0)
                                        ->whereNull('end_date')
                                        ->count();
        if ($checkAlraadyOnBench > 0) {

            return ['status' => 'error', 'message' => 'NOT DONE - Selected player already on bench'];
        }

        $playerInTeamCheak = TeamPlayerContract::where('team_id', $team->id)
                                        ->whereIN('player_id', [$lineup_player, $sub_player])
                                        ->whereNull('end_date')
                                        ->count();
        if ($playerInTeamCheak != 2) {

            return ['status' => 'error', 'message' => 'NOT DONE - Selected player is not in team'];
        }

        $availableFormations = $division->getOptionValue('available_formations');
        
        foreach ($availableFormations as $key => $value) {
            $availableFormations[$key] = '1'.$value;
        }

        if (!in_array($formation, $availableFormations)) {

            return ['status' => 'error', 'message' => 'NOT DONE - Team lineup formation is invalid'];
        }

        $teamPlayers = $this->getTeamTransferPlayersPositionWise($division, $team);
        foreach ($teamPlayers as $playerKey => $playerValue) {
            if ($playerValue->count()) {
                foreach ($playerValue as $key => $value) {
                    if ($value->subsAct == 1) {
                        $teamPlayersArrayDB[] = ['playerId' => $value->player_id];
                    } else {
                        $teamPlayersArrayDBDact[] = ['playerId' => $value->player_id];
                    }
                }
            }
        }

        foreach ($teamPlayersArrayDB as $key => $value) {
            if ($lineup_player == $value['playerId']) {
                unset($teamPlayersArrayDB[$key]);
            }
        }
        foreach ($teamPlayersArrayDBDact as $key => $value) {
            if ($sub_player == $value['playerId']) {
                array_push($teamPlayersArrayDB, $value);
            }
        }
        $totalPlayers = array_values(array_column($teamPlayersArrayDB, 'playerId'));
        $players = $this->getTeamPlayerPostions($team, $totalPlayers);
        $mergeDefenders = $division->getOptionValue('merge_defenders');
        $availableFormations = $division->getOptionValue('available_formations');

        if (! $this->validateTransferFormationService->checkPossibleFormation($availableFormations, $mergeDefenders, $players)) {

            return ['status' => 'error', 'message' => 'NOT DONE - Please refresh for current line-up'];
        }

        return ['status' => 'success', 'message' => 'Saved'];
    }
}
