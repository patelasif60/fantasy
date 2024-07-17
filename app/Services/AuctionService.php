<?php

namespace App\Services;

use App\Enums\AuctionTypesEnum;
use App\Enums\EventsEnum;
use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Enums\PositionsEnum;
use App\Repositories\AuctionRepository;
use App\Repositories\ClubRepository;
use App\Repositories\OnlineSealedBidRepository;
use App\Repositories\PlayerAuctionBidRepository;
use Illuminate\Support\Arr;

class AuctionService
{
    /**
     * The Auction repository instance.
     *
     * @var AuctionRepository
     */
    protected $repository;

    /**
     * The OnlineSealedBid Service instance.
     *
     * @var OnlineSealedBidService
     */
    protected $onlineSealedBidService;

    /**
     * The club repository instance.
     *
     * @var ClubRepository
     */
    protected $clubRepository;

    /**
     * The club repository instance.
     *
     * @var packageService
     */
    protected $packageService;

    /**
     * Create a new service instance.
     *
     * @param AuctionRepository $repository
     */
    public function __construct(AuctionRepository $repository, OnlineSealedBidService $onlineSealedBidService, ClubRepository $clubRepository, PackageService $packageService)
    {
        $this->repository = $repository;
        $this->clubRepository = $clubRepository;
        $this->onlineSealedBidService = $onlineSealedBidService;
        $this->packageService = $packageService;
    }

    public function getTeamPlayers($division, $team)
    {
        $teamPlayers = $this->repository->getTeamPlayers($team);
        $mergeDefenders = $division->getOptionValue('merge_defenders');
        $defensiveMidfields = $division->getOptionValue('defensive_midfields');

        return $teamPlayers->filter(function ($value, $key) use ($mergeDefenders, $defensiveMidfields) {
            if (player_position_short($value->position) == 'CB' || player_position_short($value->position) == 'FB') {
                if ($mergeDefenders == 'Yes') {
                    return $value->setAttribute('shortPosition', 'DF');
                }

                return $value->setAttribute('shortPosition', player_position_short($value->position));
            } elseif (player_position_short($value->position) == 'DMF') {
                if ($defensiveMidfields == 'Yes') {
                    return $value->setAttribute('shortPosition', 'DF');
                }

                return $value->setAttribute('shortPosition', 'MF');
            }

            return $value->setAttribute('shortPosition', player_position_short($value->position));
        });
    }

    public function createContractSealBid($data)
    {
        return $this->repository->create($data);
    }

    public function getDivisionTeamsDetails($division)
    {
        $user = auth()->user();
        $defaultSquadSize = $division->getOptionValue('default_squad_size');
        $divisionTeams = $this->repository->getDivisionTeamsDetails($division);

        return $divisionTeams->filter(function ($value, $key) use ($defaultSquadSize, $user) {
            $value->setAttribute('crest', $value->getCrestImageThumb());
            $value->setAttribute('defaultSquadSize', $defaultSquadSize);
            $value->setAttribute('ownTeam', $user->can('ownTeam', $value));
            $value->setAttribute('team_players_count', $value->transferBudget->count());
            unset($value['transferBudget']);

            return $value->setAttribute('defaultSquadSize', $defaultSquadSize);
        });
    }

    public function getPlayers($division, $team, $data)
    {
        if (Arr::has($data, 'position') && Arr::get($data, 'position')) {
            $data['position'] = $division->getPositionFullName($data['position']);
        }

        $players = $this->repository->getPlayers($division, $team, $data);
        $playerPositions = PositionsEnum::toSelectArray();
        $divisionService = app(DivisionService::class);
        $divisionPoints = $divisionService->getDivisionPoints($division, $playerPositions);

        $players->each(function ($item, $key) use ($divisionPoints, $division) {
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

            $total = 0;
            $total += $goal * $item->total_goal;
            $total += $assist * $item->total_assist;
            $total += $goalConceded * $item->total_goal_against;
            $total += $cleanSheet * $item->total_clean_sheet;
            $total += $appearance * $item->total_game_played;
            $total += $clubWin * $item->total_club_win;
            $total += $yellowCard * $item->total_yellow_card;
            $total += $redCard * $item->total_red_card;
            $total += $ownGoal * $item->total_own_goal;
            $total += $penaltyMissed * $item->total_penalty_missed;
            $total += $penaltySave * $item->total_penalty_saved;
            $total += $goalkeeperSave * $item->total_goalkeeper_save;

            $item->total = $total;

            unset($item->total_goal, $item->total_assist, $item->total_goal_against, $item->total_clean_sheet);

            $item->playerPositionFull = $item->position;
            $item->position = $division->getPositionShortCode($position);
        });

        return $players;
    }

    public function getClubs($where = [])
    {
        return $this->clubRepository->listWithShortCode();
    }

    public function getPositions($division)
    {
        $positions = ($division->playerPositionEnum())::toSelectArray();
        $formatedPositions = [];
        $playersCollection = collect($positions)->map(function ($item, $key) use (&$formatedPositions, $division) {
            $pos = $division->getPositionShortCode(player_position_short($key));

            return $formatedPositions[$pos] = $item.'s';
        });

        return $formatedPositions;
    }

    public function getTeamPlayersCount($team)
    {
        return $this->repository->getTeamPlayersCount($team);
    }

    public function getTeamPlayerPostionsCount($division, $team)
    {
        $mergeDefenders = $division->getOptionValue('merge_defenders');
        $defensiveMidfields = $division->getOptionValue('defensive_midfields');
        $teamPositions = $this->repository->getTeamPlayerPostions($team)->pluck('total', 'position')->toArray();
        if (! array_has($teamPositions, AllPositionEnum::GOALKEEPER)) {
            $teamPositions[AllPositionEnum::GOALKEEPER] = 0;
        }
        if (! array_has($teamPositions, AllPositionEnum::STRIKER)) {
            $teamPositions[AllPositionEnum::STRIKER] = 0;
        }
        if ($mergeDefenders == 'Yes') {
            $total = 0;
            if (array_has($teamPositions, AllPositionEnum::FULLBACK)) {
                $total += $teamPositions[AllPositionEnum::FULLBACK];
            }
            if (array_has($teamPositions, AllPositionEnum::CENTREBACK)) {
                $total += $teamPositions[AllPositionEnum::CENTREBACK];
            }
            unset($teamPositions[AllPositionEnum::FULLBACK]);
            unset($teamPositions[AllPositionEnum::CENTREBACK]);
            $teamPositions[AllPositionEnum::DEFENDER] = $total;
        } else {
            if (! array_has($teamPositions, AllPositionEnum::FULLBACK)) {
                $teamPositions[AllPositionEnum::FULLBACK] = 0;
            }
            if (! array_has($teamPositions, AllPositionEnum::CENTREBACK)) {
                $teamPositions[AllPositionEnum::CENTREBACK] = 0;
            }
        }
        if ($defensiveMidfields == 'Yes') {
            if (! array_has($teamPositions, AllPositionEnum::DEFENSIVE_MIDFIELDER)) {
                $teamPositions[AllPositionEnum::DEFENSIVE_MIDFIELDER] = 0;
            } else {
                $teamPositions[AllPositionEnum::DEFENSIVE_MIDFIELDER] = $teamPositions[AllPositionEnum::DEFENSIVE_MIDFIELDER];
            }
            if (! array_has($teamPositions, AllPositionEnum::MIDFIELDER)) {
                $teamPositions[AllPositionEnum::MIDFIELDER] = 0;
            } else {
                $teamPositions[AllPositionEnum::MIDFIELDER] = $teamPositions[AllPositionEnum::MIDFIELDER];
            }
        } else {
            $total = 0;
            if (array_has($teamPositions, AllPositionEnum::MIDFIELDER)) {
                $total += $teamPositions[AllPositionEnum::MIDFIELDER];
            }
            if (array_has($teamPositions, AllPositionEnum::DEFENSIVE_MIDFIELDER)) {
                $total += $teamPositions[AllPositionEnum::DEFENSIVE_MIDFIELDER];
            }
            unset($teamPositions[AllPositionEnum::DEFENSIVE_MIDFIELDER]);
            $teamPositions[AllPositionEnum::MIDFIELDER] = $total;
        }

        return $teamPositions = collect($teamPositions)->mapWithKeys(function ($value, $key) {
            return [player_position_short($key) => $value];
        });
    }

    public function edit($division, $team, $data)
    {
        $teamBudget = $team->team_budget;
        $teamBudget += $data['old_amount'];
        if ($teamBudget < $data['amount']) {
            return false;
        }

        return $this->repository->edit($data, $team);
    }

    public function getTeamClubsPlayer($team)
    {
        return $this->repository->getTeamClubsPlayer($team);
    }

    public function create($division, $team, $data)
    {
        $teamBudget = $team->team_budget;
        $defaultSquadSize = $division->getOptionValue('default_squad_size');
        $maxClubPlayer = $division->getOptionValue('default_max_player_each_club');
        $teamClubPlayers = $this->repository->getTeamClubPlayers($team->id, $data['club_id']);

        if ($teamBudget < $data['amount']) {
            return false;
        }
        if ($defaultSquadSize <= $team->teamPlayers->count()) {
            return false;
        }
        if ($maxClubPlayer <= $teamClubPlayers) {
            return false;
        }

        return $this->repository->create($data, $team);
    }

    public function getTeamClubPlayers($team, $club)
    {
        return $this->repository->getTeamClubPlayers($team, $club);
    }

    public function getplayerPosition($division, $clubId, $playerId)
    {
        $playerPosition = $this->repository->getplayerPosition($clubId, $playerId);

        if (($playerPosition == AllPositionEnum::CENTREBACK || $playerPosition == AllPositionEnum::FULLBACK) && $division->getOptionValue('merge_defenders') == 'Yes') {
            return AllPositionEnum::DEFENDER;
        }

        if ($playerPosition == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
            return AllPositionEnum::MIDFIELDER;
        }

        return $playerPosition;
    }

    public function close($division)
    {
        $division->divisionTeams->where('is_approved', true)->each(function ($item, $key) use ($division) {
            $teamPlayers = $this->repository->getTeamPlayerContracts($item);
            $teamPlayers->filter(function ($value, $key) use ($division) {
                if ($division->getOptionValue('merge_defenders') == 'Yes') {
                    if ($value->position == AllPositionEnum::CENTREBACK ||
                        $value->position == AllPositionEnum::FULLBACK
                    ) {
                        return $value->setAttribute('position', AllPositionEnum::DEFENDER);
                    }
                }

                if ($value->position == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
                    return $value->setAttribute('position', AllPositionEnum::MIDFIELDER);
                }
            });
            $this->setTeamFormations($division, $teamPlayers->groupBy('position'));
        });

        $this->repository->closeDivision($division);

        //Create Transfer 1st Round when division auction close
        $transferRoundService = app(TransferRoundService::class);
        $newRound = $transferRoundService->firstRoundStore($division);

        if ($newRound) {
            $transferRoundService->sendEmailTransferRoundCreated($division, $newRound);

            //Create transfer round tie preference
            $onlineSealedBidTransferService = app(OnlineSealedBidTransferService::class);
            $onlineSealedBidTransferService->transferRoundTiePreference($division, $division->getOptionValue('tie_preference'), $newRound);
        }

        return $division;
    }

    public function setTeamFormations($division, $teamPlayers)
    {
        $availableFormations = collect($division->getOptionValue('available_formations'));

        foreach ($availableFormations as $formationKey => $formationValue) {
            $formationValue = '1'.$formationValue;

            $formationArr = str_split($formationValue);
            $fullback = 2;
            $centreback = 2;
            if ($formationArr[1] == 5) {
                $centreback = 3;
            }

            if (count($teamPlayers[AllPositionEnum::GOALKEEPER]) < $formationArr[0]) {
                continue;
            }

            if ($division->getOptionValue('merge_defenders') == 'Yes') {
                if (count($teamPlayers[AllPositionEnum::DEFENDER]) < $formationArr[1]) {
                    continue;
                }
            } else {
                if (count($teamPlayers[AllPositionEnum::CENTREBACK]) < $centreback) {
                    continue;
                }
                if (count($teamPlayers[AllPositionEnum::FULLBACK]) < $fullback) {
                    continue;
                }
            }

            if (count($teamPlayers[AllPositionEnum::MIDFIELDER]) < $formationArr[2]) {
                continue;
            }
            if (count($teamPlayers[AllPositionEnum::STRIKER]) < $formationArr[3]) {
                continue;
            }

            foreach ($teamPlayers as $positionKey => $positionValue) {
                if ($positionKey == AllPositionEnum::GOALKEEPER) {
                    foreach ($positionValue as $key => $value) {
                        if ($key == 0) {
                            $this->repository->update($value->team_id, $value->player_id);
                        }
                    }
                }
                if ($positionKey == AllPositionEnum::STRIKER) {
                    foreach ($positionValue as $key => $value) {
                        if ($key < $formationArr[3]) {
                            $this->repository->update($value->team_id, $value->player_id);
                        }
                    }
                }
                if ($positionKey == AllPositionEnum::MIDFIELDER) {
                    foreach ($positionValue as $key => $value) {
                        if ($key < $formationArr[2]) {
                            $this->repository->update($value->team_id, $value->player_id);
                        }
                    }
                }

                if ($division->getOptionValue('merge_defenders') == 'Yes') {
                    if ($positionKey == AllPositionEnum::DEFENDER) {
                        foreach ($positionValue as $key => $value) {
                            if ($key < $formationArr[1]) {
                                $this->repository->update($value->team_id, $value->player_id);
                            }
                        }
                    }
                } else {
                    if ($positionKey == AllPositionEnum::CENTREBACK) {
                        foreach ($positionValue as $key => $value) {
                            if ($key < $centreback) {
                                $this->repository->update($value->team_id, $value->player_id);
                            }
                        }
                    }

                    if ($positionKey == AllPositionEnum::FULLBACK) {
                        foreach ($positionValue as $key => $value) {
                            if ($key < $fullback) {
                                $this->repository->update($value->team_id, $value->player_id);
                            }
                        }
                    }
                }
            }

            break;
        }
    }

    public function getTeamPlayerPostions($team)
    {
        return $this->repository->getTeamPlayerPostions($team)->pluck('total', 'position')->toArray();
    }

    public function getTeamPlayersPositionWise($division, $team)
    {
        $teamPlayers = $this->repository->getTeamPlayers($team);
        $teamPlayers->map(function ($item, $value) {
            $fixture = $this->repository->getNextFixture($item->club_id);

            return $item->setAttribute('nextFixture', $fixture ? $fixture->date_time : '');
        });
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

    public function allTeamSizeFull($division)
    {
        if (! $division->divisionTeams->count()) {
            return false;
        }

        $defaultSquadSize = $division->getOptionValue('default_squad_size');
        foreach ($division->divisionTeams as $key => $team) {
            if ($team->is_approved) {
                if ($team->teamPlayers->count() < $defaultSquadSize) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getTeamDetails($division, $team)
    {
        $team->setAttribute('crest', $team->getCrestImageThumb());

        $team->setAttribute('team_players_count', $team->transferBudget->count());

        unset($team['transferBudget']);

        return $team->setAttribute('defaultSquadSize', $division->getOptionValue('default_squad_size'));
    }

    public function destroy($division, $team, $player)
    {
        if ($this->repository->destroy($division, $team, $player)) {
            return true;
        }

        return false;
    }

    public function reset($division)
    {
        if ($division->getOptionValue('auction_types') == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {

            $service = app(OnlineSealedBidService::class);
            $service->resetSealBid($division);
        }

        if ($division->getOptionValue('auction_types') == AuctionTypesEnum::OFFLINE_AUCTION) {
            
            $this->resetLiveOfflineAuction($division);
        }

        $division->update([
            'auction_date' => null,
        ]);

        return $division;
    }

    public function resetLiveOfflineAuction($division)
    {
        return $this->repository->resetLiveOfflineAuction($division);
    }

    public function getPreAuctionDetails($division)
    {
        return $this->repository->getPreAuctionDetails($division);
    }

    public function auctionPackPdfDownload($division)
    {
        $teamsCount = $division->divisionTeamsCurrentSeason->count();
        $data['team_sheet_horizontal_pdf'] = url('/').config('division.pdf.team_sheet.horizontal');
        $data['team_sheet_vertical_pdf'] = url('/').config('division.pdf.team_sheet.vertical');
        if ($teamsCount <= 8) {
            $data['auction_tracker_pdf'] = url('/').config('division.pdf.auction_tracker.5-8');

            return $data;
        }
        if ($teamsCount <= 12) {
            $data['auction_tracker_pdf'] = url('/').config('division.pdf.auction_tracker.9-12');

            return $data;
        }
        $data['auction_tracker_pdf'] = url('/').config('division.pdf.auction_tracker.13-16');

        return $data;
    }

    public function isAuctionEntryStart($division)
    {
        $count = 0;

        if ($division->getOptionValue('auction_types') == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
            $teamIds = $division->divisionTeams()->approve()->pluck('team_id');
            $onlineSealedBidRepository = app(OnlineSealedBidRepository::class);
            $count = $onlineSealedBidRepository->isAuctionEntryStart($teamIds);
        }

        if ($division->getOptionValue('auction_types') == AuctionTypesEnum::OFFLINE_AUCTION) {
            $teamIds = $division->divisionTeams()->approve()->pluck('team_id');
            $count = $this->repository->isAuctionEntryStart($teamIds);
        }

        if ($division->getOptionValue('auction_types') == AuctionTypesEnum::LIVE_ONLINE_AUCTION) {
            $playerAuctionBidRepository = app(PlayerAuctionBidRepository::class);
            $count = $playerAuctionBidRepository->isAuctionEntryStart($division);
        }

        return $count > 0 ? true : false;
    }

    public function startAuction($division, $start)
    {
        return $this->repository->startAuction($division, $start);
    }

    public function checkAuctionPlayerInAnotherTeam($division, $player)
    {
        return $this->repository->checkAuctionPlayerInAnotherTeam($division, $player);
    }
}
