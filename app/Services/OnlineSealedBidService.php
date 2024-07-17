<?php

namespace App\Services;

use App\Enums\EventsEnum;
use App\Enums\OnlineSealedBidStatusEnum;
use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Enums\PositionsEnum;
use App\Enums\TiePreferenceEnum;
use App\Enums\YesNoEnum;
use App\Jobs\OnlineSealedBidsAuctionCompletedEmail;
use App\Jobs\OnlineSealedBidsRoundProcessedEmail;
use App\Jobs\ProcessOnlineSealBidRoundManual;
use App\Models\Team;
use App\Repositories\AuctionRepository;
use App\Repositories\OnlineSealedBidRepository;
use Illuminate\Support\Arr;

class OnlineSealedBidService
{
    /**
     * The OnlineSealedBid repository instance.
     *
     * @var OnlineSealedBidRepository
     */
    protected $repository;

    /**
     * The AuctionRepository Repository instance.
     *
     * @var AuctionRepository
     */
    protected $auctionRepository;

    /**
     * The TiePreferenceService Service instance.
     *
     * @var TiePreferenceService
     */
    protected $tiePreferenceService;

    /**
     * The AuctionRoundService Service instance.
     *
     * @var auctionRoundService
     */
    protected $auctionRoundService;

    /**
     * The Package Service instance.
     *
     * @var PackageService
     */
    protected $packageService;

    /**
     * Create a new service instance.
     *
     * @param OnlineSealedBidRepository $repository
     */
    public function __construct(OnlineSealedBidRepository $repository, AuctionRepository $auctionRepository, TiePreferenceService $tiePreferenceService, AuctionRoundService $auctionRoundService, PackageService $packageService)
    {
        $this->repository = $repository;
        $this->packageService = $packageService;
        $this->auctionRepository = $auctionRepository;
        $this->tiePreferenceService = $tiePreferenceService;
        $this->auctionRoundService = $auctionRoundService;
    }

    public function create($division, $team, $round, $data)
    {
        return $this->repository->create($division, $team, $round, $data);
    }

    public function update($onlineSealedBid, $data)
    {
        return $this->repository->update($onlineSealedBid, $data);
    }

    public function updateStatus($onlineSealedBid, $status)
    {
        return $this->repository->updateStatus($onlineSealedBid, $status);
    }

    public function getRoundStartTeams($now)
    {
        return $this->repository->getRoundStartTeams($now);
    }

    public function getPlayers($division, $team, $data, $round, $isMobile = false)
    {
        if (Arr::has($data, 'position') && Arr::get($data, 'position')) {
            $data['position'] = $division->getPositionFullName($data['position']);
        }

        $players = $this->repository->getPlayers($division, $team, $data, $round, $isMobile);
        $playersStats = $this->repository->getPlayersStats($players->pluck('playerId'));

        $positionOrder = $division->getPositionOrder();

        $division->load('package.packagePoints');
        $playerPositions = PositionsEnum::toSelectArray();
        $packagePointCalculation = $this->packageService->getPackagePoints($division->package, $playerPositions);

        $players->map(function ($item, $key) use ($packagePointCalculation, $team, $division, $positionOrder, $playersStats, $isMobile) {
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
            $item->sealed_bid_amount = auth()->user()->can('ownTeam', $team) ? $item->sealed_bid_amount : 0;
            
            $pos = $division->getPositionShortCode($pos);
            $item->playerPositionShort = $pos;
            $item->positionOrder = isset($positionOrder[$pos]) ? $positionOrder[$pos] : 0;

            if ($isMobile) {
                $item->tshirt = player_tshirt($item->playerClubShortCode, $pos);
            }

        });

        return $players;
    }

    public function getBids($division, $team, $round, $data)
    {
        if (! auth()->user()->can('ownTeam', $team) && Arr::get($data, 'status') == OnlineSealedBidStatusEnum::PENDING) {
            return collect([]);
        }

        if (Arr::has($data, 'position') && Arr::get($data, 'position')) {
            $data['position'] = $division->getPositionFullName($data['position']);
        }

        $bids = $this->repository->getBids($division, $team, $round, $data);
        $positionOrder = $division->getPositionOrder();

        $bids->map(function ($item, $key) use ($division, $positionOrder) {
            $pos = $division->getPositionShortCode(player_position_short($item->playerPosition));
            $item->playerPositionShort = $pos;
            $item->positionOrder = isset($positionOrder[$pos]) ? $positionOrder[$pos] : 0;
        });

        return $bids;
    }

    public function getManualBidRoundData($division, $round)
    {
        return $this->repository->getBidRoundData($division, YesNoEnum::YES, $round);
    }

    public function getAutomaticBidRoundData($division)
    {
        return $this->repository->getBidRoundData($division, YesNoEnum::NO);
    }

    public function getActiveBidDivision()
    {
        return $this->repository->getActiveBidDivision();
    }

    public function getplayersMaxBidAmount($onlineSealedBids)
    {
        return $onlineSealedBids->where('amount', $onlineSealedBids->max('amount'));
    }

    public function playerSortByTiePreference($maxBidPlayers, $tiePreference)
    {
        if ($tiePreference === TiePreferenceEnum::EARLIEST_BID_WINS) {
            $sortData = $maxBidPlayers->sortBy(function ($obj, $key) {
                return $obj->created_at->unix();
            });
        } elseif ($tiePreference === TiePreferenceEnum::RANDOMLY_ALLOCATED || $tiePreference === TiePreferenceEnum::RANDOMLY_ALLOCATED_REVERSES) {
            $sortData = $maxBidPlayers->sortBy('number');
        } else {
            $sortData = $maxBidPlayers->shuffle();
        }

        return $sortData;
    }

    // public function checkClubQuota($sortPlayers, $default_max_player_each_club)
    // {
    //     foreach ($sortPlayers as $player) {
    //         $teamClubsPlayer = $this->repository->getClubIdWithCount($player->team_id);

    //         if (isset($teamClubsPlayer[$player->club_id]) && $teamClubsPlayer[$player->club_id] === $default_max_player_each_club) {
    //             continue;
    //         } else {
    //             return $player;
    //         }
    //     }

    //     return false;
    // }

    public function checkBudgetQuota($sortPlayers)
    {
        foreach ($sortPlayers as $player) {
            $team = Team::find($player->team_id);

            if ($player->amount <= $team->team_budget) {
                return $player;
            }

            continue;
        }

        return false;
    }

    public function startOnlineSealedBidProcess($onlineSealedBids, $division, $endRound)
    {
        info('Online seabid process function start.');
        $tiePreference = $division->getOptionValue('tie_preference');

        $roundStartDate = $division->auction_date;
        $firstReound = $division->auctionRounds()->first();
        if ($firstReound) {
            $roundStartDate = $firstReound->start;
        }

        //$default_max_player_each_club = $division->getOptionValue('default_max_player_each_club');

        $onlineSealedBidsGroupBy = $onlineSealedBids->groupBy('player_id');

        foreach ($onlineSealedBidsGroupBy as $onlineSealedBids) {
            $maxBidPlayers = $this->getplayersMaxBidAmount($onlineSealedBids);
            $sortPlayers = $this->playerSortByTiePreference($maxBidPlayers, $tiePreference);
            //$clubQuotaPlayer = $this->checkClubQuota($sortPlayers, $endRound, $default_max_player_each_club);
            $winner = $this->checkBudgetQuota($sortPlayers);

            foreach ($onlineSealedBids as $onlineSealedBid) {
                $status = ($winner && $winner->team_id == $onlineSealedBid->team_id) ? OnlineSealedBidStatusEnum::WON : OnlineSealedBidStatusEnum::LOST;
                $this->updateStatus($onlineSealedBid, $status);
                if ($status === OnlineSealedBidStatusEnum::WON) {
                    $this->repository->createTeamPlayerContract($roundStartDate, $onlineSealedBid);
                }
            }
        }

        $endRound->processed();
        $auctionService = app(AuctionService::class);

        $closeAuction = false;
        if ($auctionService->allTeamSizeFull($division)) {
            $auctionService->close($division);
            OnlineSealedBidsAuctionCompletedEmail::dispatch($division);
            $closeAuction = true;
        } else {
            $this->auctionRoundTiePreference($division, $tiePreference);
            $newRoundCount = $this->checkUnProcessRoundCount($division, $endRound->end);
            if (! $newRoundCount) {
                $this->auctionRoundService->createFromLastRound($endRound);
            }
        }

        if (! $closeAuction) {
            OnlineSealedBidsRoundProcessedEmail::dispatch($division);
        }

        info('Online seabid process function end.');

        return true;
    }

    public function auctionRoundTiePreference($division, $tiePreference)
    {
        if ($tiePreference === TiePreferenceEnum::RANDOMLY_ALLOCATED || $tiePreference === TiePreferenceEnum::RANDOMLY_ALLOCATED_REVERSES) {
            $teamIds = $division->divisionTeams()->approve()->pluck('team_id');
            $this->tiePreferenceService->create($tiePreference, $teamIds);
        }
    }

    public function checkUnProcessRoundCount($division, $endDate)
    {
        return $this->repository->checkUnProcessRoundCount($division, $endDate);
    }

    public function getClubIdWithCount($teamId, $round)
    {
        $sealBidQuota = $this->repository->getSealBidClubIdWithCount($teamId, $round);
        $quota = $this->repository->getClubIdWithCount($teamId);
        $merged = $sealBidQuota->keys()->merge($quota->keys());
        $clubs = collect();
        $merged->each(function ($item, $key) use ($clubs, $sealBidQuota, $quota) {
            $clubs[$item] = $sealBidQuota->get($item, 0) + $quota->get($item, 0);
        });

        return $clubs;
    }

    public function getTeams($division, $round)
    {
        $teams = $this->repository->getSealBidTeams($division);

        $teams->filter(function ($team, $key) use ($round) {
            $bidsWin = $team->onlineSealedBids->where('status', OnlineSealedBidStatusEnum::WON)->count();
            $bidsInRound = $team->onlineSealedBids->where('auction_rounds_id', $round->id)->count();

            $bidAmount = 0;
            // if (auth()->user()->can('ownTeam', $team)) {
            //     $bidAmount = $team->onlineSealedBids->where('auction_rounds_id', $round->id)->sum('amount');
            // }

            $team->setAttribute('bidsInRound', $bidsInRound);
            $team->setAttribute('bidsWin', $bidsWin);
            $team->setAttribute('totalBids', $bidsWin + $bidsInRound);
            $team->setAttribute('crest', $team->getCrestImageThumb());

            unset($team['onlineSealedBids']);

            return $team->setAttribute('budget', set_if_float_number_format($team->team_budget - $bidAmount));
        });

        return $teams;
    }

    public function sealBidProcessManual($division, $round)
    {
        if($round) {
            $division->roundProcess(true);
            ProcessOnlineSealBidRoundManual::dispatch($division, $round);
        }

        return true;
    }

    public function resetSealBid($division)
    {
        return $this->repository->resetSealBid($division);
    }

    public function getTeamPlayerPositions($team, $round)
    {
        $playersPositions = $this->auctionRepository->getTeamPlayerPositions($team)->pluck('total', 'position');
        $playersPositionsSealBids = $this->repository->getSealedBidTeamPlayerPositions($team, $round)->pluck('total', 'position');

        $data = collect();
        foreach (AllPositionEnum::toArray() as $position) {
            $sum = $playersPositions->get($position, 0) + $playersPositionsSealBids->get($position, 0);
            if ($sum > 0) {
                $data[$position] = $sum;
            }
        }

        return $data->toArray();
    }

    public function getAllPitchPlayer($division, $team)
    {
        $teamPlayers = $this->repository->getTeamPlayers($team);

        $playerPositions = PositionsEnum::toSelectArray();
        $packagePointCalculation = $this->packageService->getPackagePoints($division->package, $playerPositions);

        $teamPlayers->map(function ($item, $value) use ($packagePointCalculation) {
            $item->setAttribute('isSealBid', false);

            $pos = player_position_short($item->position);

            $item->total_goal = isset($packagePointCalculation[$pos][EventsEnum::GOAL]) && $packagePointCalculation[$pos][EventsEnum::GOAL] ? $packagePointCalculation[$pos][EventsEnum::GOAL] * $item->total_goal : $item->total_goal;
            $item->total_assist = isset($packagePointCalculation[$pos][EventsEnum::ASSIST]) && $packagePointCalculation[$pos][EventsEnum::ASSIST] ? $packagePointCalculation[$pos][EventsEnum::ASSIST] * $item->total_assist : $item->total_assist;
            $item->total_goal_against = isset($packagePointCalculation[$pos][EventsEnum::GOAL_CONCEDED]) && $packagePointCalculation[$pos][EventsEnum::GOAL_CONCEDED] ? $packagePointCalculation[$pos][EventsEnum::GOAL_CONCEDED] * $item->total_goal_against : $item->total_goal_against;
            $item->total_clean_sheet = isset($packagePointCalculation[$pos][EventsEnum::CLEAN_SHEET]) && $packagePointCalculation[$pos][EventsEnum::CLEAN_SHEET] ? $packagePointCalculation[$pos][EventsEnum::CLEAN_SHEET] * $item->total_clean_sheet : $item->total_clean_sheet;

            $total_points = $item->total_goal + $item->total_assist + $item->total_goal_against + $item->total_clean_sheet;
            $item->setAttribute('total_points', $total_points);

            return $item;
        });

        return $teamPlayers->groupBy('position');
    }

    public function getAllSealBidPitchPlayer($division, $team, $round, $user)
    {
        if ($user->can('ownTeam', $team)) {
            $teamPlayersSealBid = $this->repository->getTeamPlayersSealBid($team, $round);
            $teamPlayersSealBid->map(function ($item, $value) {
                $item->setAttribute('isSealBid', true);

                return $item;
            });

            return $teamPlayersSealBid->groupBy('position');
        }

        return collect();
    }

    public function getTeamPlayersPositionWise($division, $team, $round, $user)
    {
        $teamPlayers = $this->getAllPitchPlayer($division, $team);
        $teamPlayersSealBid = $this->getAllSealBidPitchPlayer($division, $team, $round, $user);

        $data = collect();
        foreach (AllPositionEnum::toSelectArray() as $posKey =>  $position) {
            $data[$posKey] = $teamPlayers->get($posKey, collect())->concat($teamPlayersSealBid->get($posKey, collect()));
        }

        $auctionCommanService = app(AuctionCommanService::class);

        $teamPlayers = $auctionCommanService->setPlayerPositions($division, $data);

        $formatedPlayers = [];
        $playersCollection = collect($teamPlayers)->map(function ($item, $key) use (&$formatedPlayers, $division) {
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

    public function getTeamDetails($division, $team, $round)
    {
        $actualContract = $team->teamPlayers->count();
        $sealBidContract = $this->repository->getCurrentSealBidCount($round, $team);

        $team->setAttribute('crest', $team->getCrestImageThumb());
        $team->setAttribute('defaultSquadSize', $division->getOptionValue('default_squad_size'));
        $team->setAttribute('squadSize', $actualContract);
        $team->setAttribute('squadSizeSealBid', $sealBidContract);
        $team->setAttribute('budget', $this->getBudget($team, $round));
        unset($team['teamPlayers']);

        return $team;
    }

    public function getBudget($team, $round)
    {
        $bidAmount = 0;
        if (auth()->user()->can('ownTeam', $team)) {
            $bidAmount = $team->onlineSealedBids()->where('auction_rounds_id', $round->id)->sum('amount');
        }

        return number_format($team->team_budget - $bidAmount, 2, '.', '');
    }

    public function getSocialLeagues()
    {
        return $this->repository->getSocialLeagues();
    }
}
