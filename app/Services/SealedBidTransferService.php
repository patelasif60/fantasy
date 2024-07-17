<?php

namespace App\Services;

use App\Enums\EventsEnum;
use App\Enums\MoneyBackEnum;
use Illuminate\Support\Arr;
use App\Enums\PositionsEnum;
use App\Enums\TiePreferenceEnum;
use App\Models\TeamPlayerContract;
use App\Repositories\AuctionRepository;
use App\Jobs\ProcessTransferRoundClosed;
use App\Enums\OnlineSealedBidStatusEnum;
use App\Jobs\ProcessSingleTransferSealBid;
use App\Repositories\SealedBidTransferRepository;
use App\Jobs\ProcessOnlineSealBidTransferRoundManual;
use App\Enums\PlayerContractPosition\AllPositionEnum;

class SealedBidTransferService
{
    /**
     * The SealedBidTransferRepository repository instance.
     *
     * @var SealedBidTransferRepository
     */
    protected $repository;

    protected $packageService;

    protected $formationService;

    protected $transnferTiePreferenceService;

    protected $processFlag = 'sealbid-transfer-process-start';

    public function __construct(SealedBidTransferRepository $repository, PackageService $packageService, AuctionRepository $auctionRepository, ValidateTransferFormationService $formationService, TransnferTiePreferenceService $transnferTiePreferenceService)
    {
        $this->repository = $repository;
        $this->packageService = $packageService;
        $this->auctionRepository = $auctionRepository;
        $this->formationService = $formationService;
        $this->transnferTiePreferenceService = $transnferTiePreferenceService;
    }

    public function getProcessBids($division, $team, $round)
    {
        $ties = $this->transnferTiePreferenceService->getTransferTieNumbers($division);
        $bids = $this->repository->getProcessBids($division, $team, $round);

        $bids->map(function ($item, $key) use ($ties, $division) {
            $tie = $ties->where('team_id', $item->teamId)
            ->where('transfer_rounds_id', $item->transfer_rounds_id)
            ->first();

            $item->tieOrder = $tie ? $tie->number : null;

            $item->roundNumber = 'Round '.$item->roundNumber.' - '.get_date_time_in_carbon($item->roundEndDate)->format('d/m/y H:i');

            $item->positionInShort = $division->getPositionShortCode(player_position_short($item->positionIn));
            $item->positionOutShort = $division->getPositionShortCode(player_position_short($item->positionOut));
            $item->createdAtFormated = get_date_time_in_carbon($item->created_at)->format('d M H:i');
        });

        return $bids;
    }

    public function getBidsForEarliestBids($round)
    {
        return $this->repository->getBidsForEarliestBids($round)->groupBy('player_in');
    }

    public function getBidTiePrefernceNumber($bidsGroupBy, $bid)
    {
        $playerBidData = $bidsGroupBy->get($bid->player_in);
        $sortData = $playerBidData->sortBy(function ($obj, $key) {
            return $obj->created_at->unix();
        });
        $sortData = $sortData->count() ? $sortData->pluck('team_id')->toArray() : [];

        return array_search($bid->teamId, $sortData) + 1;
    }

    public function getPendingBids($division, $team, $user, $round)
    {
        $bids = $this->repository->getPendingBids($division, $team, $user, $round);

        $bidsGroupBy = collect();
        $bidsGroupByCount = 0;
        $ties = [];
        $tiePreference = $division->getOptionValue('tie_preference');
        if ($tiePreference === TiePreferenceEnum::EARLIEST_BID_WINS) {
            $bidsGroupBy = $this->getBidsForEarliestBids($round);
            $bidsGroupByCount = $bidsGroupBy->count();
        } else {
            $ties = $this->getTiePreference($division, $tiePreference, $round);
        }

        $bids->map(function ($item, $key) use ($ties, $division,$bidsGroupBy, $bidsGroupByCount) {
            if ($bidsGroupByCount) {
                $item->tieOrder = $this->getBidTiePrefernceNumber($bidsGroupBy, $item);
            } else {
                $item->tieOrder = Arr::get($ties, $item->teamId, '-');
            }
            $item->positionInShort = $division->getPositionShortCode(player_position_short($item->positionIn));
            $item->positionOutShort = player_position_short($item->positionOut);
            $item->createdAtFormated = get_date_time_in_carbon($item->created_at)->format('d M H:i');
        });

        return $bids;
    }

    public function getTiePreference($division, $tiePreference, $round)
    {
        $teamIds = $division->divisionTeams()->approve()->pluck('team_id');
        
        if ($tiePreference === TiePreferenceEnum::LOWER_LEAGUE_POSITION_WINS || $tiePreference === TiePreferenceEnum::HIGHER_LEAGUE_POSITION_WINS) {
            if($tiePreference === TiePreferenceEnum::LOWER_LEAGUE_POSITION_WINS) {
                $allTeamData = $this->transnferTiePreferenceService->getTeamPoints($teamIds)->sortBy('league_position');
            } else {
                $allTeamData = $this->transnferTiePreferenceService->getTeamPoints($teamIds)->sortByDesc('league_position');
            }
            $teamData = [];
            $count = count($allTeamData);
            if ($count > 0) {
                foreach ($allTeamData as $value) {
                    $teamData[$value['team_id']] = $count;
                    $count--;
                }
            }
            $ties = $teamData;
        } else {
            $ties = $this->transnferTiePreferenceService->getTransferTieNumber($division, $round);
        }

        return $ties;
    }

    public function getPlayerDetails($division, $team, $playerId, $amount)
    {
        $item = $this->repository->getPlayerDetails($division, $playerId);

        if ($item) {
            $item->playerPositionShort = $division->getPositionShortCode(player_position_short($item->position));
            $item->amount = $amount;
        }

        return $item;
    }

    public function getTeamDetails($division, $team, $round)
    {
        $team->setAttribute('crest', $team->getCrestImageThumb());
        $team->setAttribute('defaultSquadSize', $division->getOptionValue('default_squad_size'));
        //$team->setAttribute('squadSize', $team->teamPlayers->count());
        $team->setAttribute('budget', $team->team_budget);

        return $team;
    }

    public function getBudget($division, $team, $round)
    {
        $moneyBack = $division->getOptionValue('money_back');

        $oldBudget = 0;

        if ($moneyBack == MoneyBackEnum::HUNDERED_PERCENT) {
            $oldBudget = $transfers->sum('transfer_value');
        }

        if ($moneyBack == MoneyBackEnum::FIFTY_PERCENT) {
            $oldBudget = ($transfers->sum('transfer_value') / 2);
        }

        return $team->team_budget + $oldBudget - $transfers->sum('amount');
    }

    public function checkbudgetValidation($division, $team, $round, $json_data)
    {
        $moneyBack = $division->getOptionValue('money_back');
        $oldPlayerBidAmount = $json_data->sum('oldPlayerAmount');
        $newPlayerBidAmount = $json_data->sum('newPlayerAmount');

        $oldBudget = 0;
        if ($moneyBack == MoneyBackEnum::HUNDERED_PERCENT) {
            $oldBudget = $oldPlayerBidAmount;
        }

        if ($moneyBack == MoneyBackEnum::FIFTY_PERCENT) {
            $oldBudget = ($oldPlayerBidAmount / 2);
        }

        return $team->team_budget + $oldBudget - $newPlayerBidAmount;
    }

    public function getPlayers($division, $team, $data, $isMobile = false)
    {
        if (Arr::has($data, 'position') && Arr::get($data, 'position')) {
            $data['position'] = $division->getPositionFullName($data['position']);
        }

        $players = $this->repository->getPlayers($division, $team, $data, $isMobile);
        $playersStats = $this->repository->getPlayersStats($players->pluck('playerId'));
        $positionOrder = $division->getPositionOrder();

        $division->load('package.packagePoints');
        $playerPositions = PositionsEnum::toSelectArray();

        $packagePointCalculation = $this->packageService->getPackagePoints($division->package, $playerPositions);

        $players->map(function ($item, $key) use ($packagePointCalculation, $team, $positionOrder, $division, $isMobile, $playersStats) {
            $pos = player_position_short($item->playerPosition);
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
            $item->playerPositionShort = $pos;
            $item->positionOrder = isset($positionOrder[$pos]) ? $positionOrder[$pos] : 0;

            if ($isMobile) {
                $item->tshirt = player_tshirt($item->playerClubShortCode, $pos);
            }
        });

        return $players;
    }

    public function getTeamPlayersPositionWise($division, $team, $isMobile = false)
    {
        $teamPlayers = $this->getAllPitchPlayer($division, $team);

        $data = collect();
        foreach (AllPositionEnum::toSelectArray() as $posKey =>  $position) {
            $data[$posKey] = $teamPlayers->get($posKey, collect());
        }

        $auctionCommanService = app(AuctionCommanService::class);

        $teamPlayers = $auctionCommanService->setPlayerPositions($division, $data);

        $formatedPlayers = [];
        $playersCollection = collect($teamPlayers)->map(function ($item, $key) use (&$formatedPlayers, $division, $isMobile) {
            $playerPositions = $item->map(function ($player) use ($division, $isMobile) {
                $pos = player_position_short($player->position);
                $player->position = $division->getPositionShortCode($pos);

                if ($isMobile) {
                    $player->tshirt = player_tshirt($player->short_code, $player->position);
                }

                return $player;
            });

            $pos = $division->getPositionShortCode(player_position_short($key));

            return $formatedPlayers[$pos] = $playerPositions;
        });

        return $formatedPlayers;
    }

    public function getAllPitchPlayer($division, $team)
    {
        $teamPlayers = $this->repository->getTeamPlayers($team);

        return $teamPlayers->groupBy('position');
    }

    public function getPlayerContractIds($team)
    {
        return $this->repository->getPlayerContractIds($team)->toArray();
    }

    public function getTeamPlayersPositionOnly($playerMergeIds)
    {
        return $this->repository->getTeamPlayersPositionOnly($playerMergeIds)->pluck('total', 'position')->toArray();

        //return $players->groupBy('position')->map->count();
    }

    public function formationValidation($division, $team, $json_data)
    {
        $json_data = $json_data->toArray();
        $playerContractIds = $this->getPlayerContractIds($team);

        $oldPlayerIds = Arr::pluck($json_data, 'oldPlayerId');
        $newPlayerIds = Arr::pluck($json_data, 'newPlayerId');
        $playerIdWithDiff = array_diff($playerContractIds, $oldPlayerIds);
        $playerMergeIds = array_merge($playerIdWithDiff, $newPlayerIds);

        $players = $this->getTeamPlayersPositionOnly($playerMergeIds);

        $availableFormations = $division->getOptionValue('available_formations');
        $mergeDefenders = $division->getOptionValue('merge_defenders');

        return $this->formationService->checkPossibleFormation($availableFormations, $mergeDefenders, $players);
    }

    public function store($team, $round, $json_data)
    {
        return $this->repository->store($team, $round, $json_data);
    }

    public function getSelectedPlayers($division, $team, $round, $isMobile = false)
    {
        if ($round) {
            $teamPlayers = $this->repository->getSelectedPlayers($division, $team, $round);

            $teamPlayers->map(function ($item, $value) use ($division, $isMobile) {
                $pos = $division->getPositionShortCode(player_position_short($item->position));
                $item->setAttribute('position_short', $pos);
                if ($isMobile) {
                    $item->tshirt = player_tshirt($item->short_code, $pos);
                }
            });

            return $teamPlayers;
        }

        return collect();
    }

    public function checkBidIncrement($sealBidIncrement, $json_data)
    {
        if ($sealBidIncrement == 0) {
            return true;
        }

        foreach ($json_data as $key => $value) {
            if (! check_number_is_divisible($sealBidIncrement, $value['newPlayerAmount'])) {
                return false;
            }
        }

        return true;
    }

    public function getClubIdWithCount($teamId)
    {
        return $this->repository->getClubIdWithCount($teamId);
    }

    public function checkClubQuota($team, $maxClubPlayers, $json_data)
    {
        $teamClubsPlayer = $this->getClubIdWithCount($team->id)->toArray();
        $clubs = $json_data->groupBy('club_id');

        foreach ($clubs as $key => $value) {
            $clbCount = $value->count();

            if (! isset($teamClubsPlayer[$key])) {
                $teamClubsPlayer[$key] = $clbCount;
            } else {
                $teamClubsPlayer[$key] = $teamClubsPlayer[$key] - $clbCount;
            }
        }

        foreach ($teamClubsPlayer as $count) {
            if ($count > $maxClubPlayers) {
                return false;
            }
        }

        return true;
    }

    public function playerInitials($teamPlayer, $sealBidPlayer)
    {
        $playerService = app(PlayerService::class);
        $a = collect($teamPlayer)->flatten()->pluck('player_last_name');
        $b = $sealBidPlayer->pluck('player_last_name');

        return $playerService->playerInitialCount($a->merge($b));
    }

    public function setSession()
    {
        session([$this->processFlag => true]);

        return true;
    }

    public function sealBidProcessManual($division, $round)
    {
        $isRoundProcessed = $this->isRoundProcessed($round);
        
        if($isRoundProcessed) {

            return true;
        }

        info('Transfer round Process block start');
        $this->setSession();
        $division->roundProcess(true);

        ProcessOnlineSealBidTransferRoundManual::dispatch($division, $round);

        return true;
    }

    public function isJobExecuted($division)
    {
        $data = ['status' => false];

        if (! $division->is_round_process) {
            $status = session()->get($this->processFlag, false);
            if ($status) {
                session()->forget($this->processFlag);
                $data = ['status' => true];
            }
        }

        return $data;
    }

    public function getManualBidRoundData($division)
    {
        return $this->repository->getBidRoundData($division);
    }

    public function isRoundProcessed($round)
    {
        return $this->repository->isRoundProcessed($round);
    }

    public function isPlayerExist($division, $playerId)
    {
        return $this->repository->isPlayerExist($division, $playerId);
    }

    public function getTeamPlayerClubWithPlayerId($division, $team, $totalPlayers)
    {
        return $this->repository->getTeamPlayerClubWithPlayerId($division, $team, $totalPlayers);
    }

    public function getPlayerClubId($playerId)
    {
        $contract = $this->repository->getPlayerClubId($playerId);

        return $contract ? $contract->club_id : 0;
    }

    public function teamPlayerClubQuotaSealBid($division, $team, $sealbid)
    {
        $default_max_player_each_club = $division->getOptionValue('default_max_player_each_club');
        $totalPlayers = array_diff($this->getPlayerContractIds($team), [$sealbid->player_out]);
        $clubs = $this->getTeamPlayerClubWithPlayerId($division, $team, $totalPlayers);
        $inPlayerClub = $this->getPlayerClubId($sealbid->player_in);
        $total = $clubs->get($inPlayerClub, 0) + 1;
        if ($total) {
            if ($default_max_player_each_club < $total) {
                return false;
            }
        }

        return true;
    }

    public function checkTeamPlayerValidation($division, $team, $sealbid)
    {
        $isValidClubQuota = $this->teamPlayerClubQuotaSealBid($division, $team, $sealbid);

        if (! $isValidClubQuota) {

            return ['message' => 'This change cannot be made as the squad exceeds your league’s club quota', 'status' => false];
        }

        $isValidFormation = $this->teamPlayerFormationSealBid($division, $team, $sealbid);

        if (! $isValidFormation) {
            
            return ['message' => 'This change cannot be made as it leaves the team with an invalid formation. It may be possible to action this change by making substitutions for this team', 'status' => false];
        }

        $moneyBack = $division->getOptionValue('money_back');
        $oldPlayerBidAmount = $this->getPlayerTransferAmount($sealbid);
        $newPlayerBidAmount = $sealbid->amount;

        $oldBudget = 0;
        if ($moneyBack == MoneyBackEnum::HUNDERED_PERCENT) {
            $oldBudget = $oldPlayerBidAmount;
        }

        if ($moneyBack == MoneyBackEnum::FIFTY_PERCENT) {
            $oldBudget = ($oldPlayerBidAmount / 2);
        }

        $budget = (($team->team_budget + $oldBudget) - $newPlayerBidAmount);

        info('Team Budget on single bid process : '.$budget);

        if ($budget < 0) {
            return ['message' => 'Team budget is not enough', 'status' => false];
        }

        return ['message' => __('messages.data.saved.success'), 'status' => true];
    }

    public function teamPlayerFormationSealBid($division, $team, $sealbid)
    {
        $playerContractIds = $this->getPlayerContractIds($team);
        $playerIdWithDiff = array_diff($playerContractIds, [$sealbid->player_out]);
        $playerMergeIds = array_merge($playerIdWithDiff, [$sealbid->player_in]);
        $players = $this->getTeamPlayersPositionOnly($playerMergeIds);
        $availableFormations = $division->getOptionValue('available_formations');
        $mergeDefenders = $division->getOptionValue('merge_defenders');

        return $this->formationService->checkPossibleFormation($availableFormations, $mergeDefenders, $players);
    }

    public function processSingleBid($division, $team, $sealbid)
    {
        if ($sealbid->status) {
            ProcessSingleTransferSealBid::dispatch($division, $team, $sealbid);
        }

        return true;
    }

    public function checkAnySucecessBidInAnyRound($division, $round)
    {
        return $this->repository->checkAnySucecessBidInAnyRound($division, $round);
    }

    public function getUnProcessBids($round)
    {
        return $this->repository->getUnProcessBids($round);
    }

    public function roundClose($division, $round)
    {
        info('Transfer round Close block start');
        $this->setSession();
        $division->roundProcess(true);

        $isRoundProcessed = $this->isRoundProcessed($round);
        $sealedBidTransfers = $this->getUnProcessBids($round);

        $onlineSealedBidTransferService = app(OnlineSealedBidTransferService::class);

        foreach ($sealedBidTransfers as $sealedBidTransfer) {
            $sealBidData = ['status' => OnlineSealedBidStatusEnum::LOST, 'is_process' => true, 'manually_process_status' => 'completed'];

            $onlineSealedBidTransferService->updateStatus($sealedBidTransfer, $sealBidData);
        }

        ProcessTransferRoundClosed::dispatch($division, $round, false);

        return true;
    }

    public function isBidProcessable($division, $sealbid, $team, $round)
    {
        $message = ['status' => true, 'message' => 'Success'];

        $onlineSealedBidTransferService = app(OnlineSealedBidTransferService::class);

        $isPlayerExist = $this->isPlayerExist($division, $sealbid->player_in);

        if ($isPlayerExist) {
            $sealBidData = ['status' => OnlineSealedBidStatusEnum::LOST, 'is_process' => true, 'manually_process_status' => $sealbid->manually_process_status];

            $onlineSealedBidTransferService->updateStatus($sealbid, $sealBidData);

            $isRoundCompleted = $onlineSealedBidTransferService->isRoundCompleted($round);

            if ($isRoundCompleted) {

                ProcessTransferRoundClosed::dispatch($division, $round, false);
            }

            return  ['status' => false, 'error_but_scecess' => true, 'message' => 'The player has already been transferred to '.$isPlayerExist->team->name.' in this round.'];
        }

        $teamPlayerContracts = TeamPlayerContract::where('player_id', $sealbid->player_out)->where('team_id', $sealbid->team_id)->whereNull('end_date')->first();

        if (! $teamPlayerContracts) {
            
            $sealBidData = ['status' => OnlineSealedBidStatusEnum::LOST, 'is_process' => true, 'manually_process_status' => $sealbid->manually_process_status];

            $onlineSealedBidTransferService->updateStatus($sealbid, $sealBidData);

            $isRoundCompleted = $onlineSealedBidTransferService->isRoundCompleted($round);

            if ($isRoundCompleted) {

                ProcessTransferRoundClosed::dispatch($division, $round, false);
            }

            return ['status' => false, 'message' => 'The player could not transfer due to player contract already closed.'];
        }

        return $message;
    }

    public function checkSeasonTransferLimit($division, $team, $json_data_count)
    {
        $season_free_agent_transfer_limit = $division->getOptionValue('season_free_agent_transfer_limit');

        if (($team->season_quota_used + $json_data_count) > $season_free_agent_transfer_limit) {
            return false;
        }

        return true;
    }

    public function checkMonthlyTransferLimit($division, $team, $json_data_count)
    {
        $monthly_free_agent_transfer_limit = $division->getOptionValue('monthly_free_agent_transfer_limit');

        if (($team->monthly_quota_used + $json_data_count) > $monthly_free_agent_transfer_limit) {
            return false;
        }

        return true;
    }

    public function getPlayerTransferAmount($sealbid)
    {
        return $this->repository->getPlayerTransferAmount($sealbid);
    }
}
