<?php

namespace App\Services;

use Mail;
use Carbon\Carbon;
use App\Models\Season;
use App\Models\Fixture;
use App\Models\Division;
use App\Enums\YesNoEnum;
use App\Enums\EventsEnum;
use Illuminate\Support\Arr;
use App\Enums\PositionsEnum;
use App\Enums\AuctionTypesEnum;
use App\Enums\TeamPointsPositionEnum;
use App\Repositories\PackageRepository;
use App\Repositories\PlayerRepository;
use App\Repositories\DivisionRepository;
use App\Repositories\LinkedLeagueRepository;
use App\Jobs\OnlineSealedBidsAuctionCreatedEmail;
use App\Mail\Manager\Divisions\LeagueCreateEmail;

class DivisionService
{
    const DEFENSIVE_MID_FIELDER = 'defensive_mid_fielder';
    const MID_FIELDER = 'mid_fielder';
    const CENTRE_BACK = 'centre_back';
    const FULL_BACK = 'full_back';

    /**
     * The division repository instance.
     *
     * @var DivisionRepository
     */
    protected $repository;

    /**
     * The package service instance.
     *
     * @var PackageService
     */
    protected $packageService;

    /**
     * The linkedLeague Repository instance.
     *
     * @var LinkedLeagueRepository
     */
    protected $linkedLeagueRepository;

    /**
     * The Player Repository instance.
     *
     * @var PlayerRepository
     */
    protected $playerRepository;

    /**
     * Create a new service instance.
     *
     * @param GameWeekService $gameWeekService
     */

    /**
     * Create a new service instance.
     *
     * @param PackageService $packageService
     */

    /**
     * Create a new service instance.
     *
     * @param PackageRepository $packageRepository
     */
    public function __construct(DivisionRepository $repository, PackageRepository $packageRepository, GameWeekService $gameWeekService, PackageService $packageService, LinkedLeagueRepository $linkedLeagueRepository, PlayerRepository $playerRepository)
    {
        $this->repository = $repository;
        $this->packageRepository = $packageRepository;
        $this->gameWeekService = $gameWeekService;
        $this->packageService = $packageService;
        $this->linkedLeagueRepository = $linkedLeagueRepository;
        $this->playerRepository = $playerRepository;
    }

    public function create($data)
    {
        $division = $this->repository->create($data);
        $chairman = $division->consumer->user;
        $division->fristName = ucfirst($chairman->first_name ? $chairman->first_name : $chairman->last_name);
        $mail = Mail::to($chairman->email)->send(new LeagueCreateEmail($division));

        return $division;
    }

    public function update($division, $data)
    {
        return $this->repository->update($division, $data);
    }

    public function updateName($division, $data)
    {
        return $this->repository->updateName($division, $data);
    }

    public function updateDivision($division, $data)
    {
        if ($division->package->allow_custom_scoring == YesNoEnum::NO) {
            $data = Arr::except($data, ['goal', 'assist', 'goal_conceded', 'clean_sheet', 'appearance', 'club_win', 'red_card', 'yellow_card', 'own_goal', 'penalty_missed', 'penalty_save', 'goalkeeper_save_X5']);
        }

        return $this->repository->updateDivision($division, $data);
    }

    public function updateAuctionDivision($division, $data)
    {
        if ($division->package->allow_custom_scoring == YesNoEnum::NO) {
            $data = Arr::except($data, ['goal', 'assist', 'goal_conceded', 'clean_sheet', 'appearance', 'club_win', 'red_card', 'yellow_card', 'own_goal', 'penalty_missed', 'penalty_save', 'goalkeeper_save_X5']);
        }

        $data['auction_date'] = Carbon::parse($data['auction_date'].' '.$data['auction_time'],config('fantasy.time.timezone'))
        ->tz('UTC')
        ->format(config('fantasy.db.datetime.format'));

        return $this->repository->updateAuctionDivision($division, $data);
    }

    public function getConsumers()
    {
        return $this->repository->getConsumers();
    }

    public function getChairman($division)
    {
        return $this->repository->getChairman($division);
    }

    public function getCoChairmen($division)
    {
        return $this->repository->getCoChairmen($division);
    }

    public function getDivisions($season)
    {
        return $this->repository->getDivisions($season);
    }

    public function getSeasons()
    {
        return $this->repository->getSeasons();
    }

    public function getPackages()
    {
        return $this->packageRepository->getPackages();
    }

    public function getPackagesBySeason($season)
    {
        return $this->packageRepository->getPackagesBySeason($season);
    }

    public function getInvitationDetails($code)
    {
        return $this->repository->getInvitationDetails($code);
    }

    public function joinDivision($data)
    {
        return $this->repository->joinDivision($data);
    }

    public function getConsumerDivisions()
    {
        return $this->repository->getConsumerDivisions();
    }

    public function validateLeagueName($league_name)
    {
        return $this->repository->validateLeagueName($league_name);
    }

    public function getPreviousSeasonDivisonCount()
    {
        return $this->repository->getPreviousSeasonDivisonCount();
    }

    public function checkEuropeanTournamentAvailable($division)
    {
        return $this->repository->checkEuropeanTournamentAvailable($division);
    }

    public function checkChampionEuropaGameweekStart()
    {
        return $this->repository->checkChampionEuropaGameweekStart();
    }

    public function updateDivisionsLeague($division, $data)
    {
        return $this->repository->updateDivisionsLeague($division, $data);
    }

    public function updateDivisionsAuction($division, $data)
    {
        $auction_date = $division->auction_date;

        $oldAuctionRoundCount = $division->auctionRounds()->count();

        $division = $this->repository->updateDivisionsAuction($division, $data);

        $newAuctionRoundCount = $division->auctionRounds()->count();

        if ($data['auction_types'] == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
            if (! $division->tie_preference || (Arr::has($data, 'tie_preference') && $division->tie_preference != Arr::get($data, 'tie_preference')) || $oldAuctionRoundCount == 0 || $oldAuctionRoundCount != $newAuctionRoundCount) {
                info('Tie Prference changeed');
                $service = app(OnlineSealedBidService::class);
                $service->auctionRoundTiePreference($division, $division->getOptionValue('tie_preference'));
            }
        }

        if (! $auction_date && $data['auction_types'] == AuctionTypesEnum::ONLINE_SEALED_BIDS_AUCTION) {
            OnlineSealedBidsAuctionCreatedEmail::dispatch($division);
        }

        return $division;
    }

    public function updateDivisionsSealedBids($division, $data)
    {
        return $this->repository->updateDivisionsSealedBids($division, $data);
    }

    public function updateDivisionsSquadAndFormations($division, $data)
    {
        return $this->repository->updateDivisionsSquadAndFormations($division, $data);
    }

    public function updateDivisionsTransfer($division, $data)
    {
        $old_seal_bids_budget = $division->seal_bids_budget;
        $return = $this->repository->updateDivisionsTransfer($division, $data);
        if ($division->package->allow_season_budget == 'Yes') {
            if ($old_seal_bids_budget != $data['seal_bids_budget']) {
                $seal_bids_budget_diff = $data['seal_bids_budget'] - $old_seal_bids_budget;
                foreach ($division->divisionTeams as $key => $value) {
                    $remaninigBudget = $value->team_budget + $seal_bids_budget_diff;
                    $value->fill([
                        'team_budget' => $remaninigBudget,
                    ])->save();
                }
            }
        }

        return $return;
    }

    public function weekScore($division)
    {
        $data['startDate'] = now()->startOfWeek();
        $data['endDate'] = now()->endOfWeek();

        $gameweek = $this->gameWeekService->getActiveGameWeek();

        if (! $gameweek) {
            $gameweek = $this->gameWeekService->getLastActiveGameWeek();

            if ($gameweek) {
                $data['startDate'] = $gameweek->start;
                $data['endDate'] = $gameweek->end;
            }
        } else {
            $data['startDate'] = $gameweek->start;
            $data['endDate'] = $gameweek->end;
        }

        return $this->repository->getDivisionLeagueStandingsTeamsScoresDateWise($division, $data);
    }

    public function monthScore($division)
    {
        $data['startDate'] = now()->startOfMonth();
        $data['endDate'] = now()->endOfMonth();

        return $this->repository->getDivisionLeagueStandingsTeamsScoresDateWise($division, $data);
    }

    public function getDivisionLeagueStandingsTeamsScores($division, $data = null)
    {
        $divisionTeamsAll = $this->repository->getDivisionLeagueStandingsTeamsScores($division, $data);

        if (Arr::has($data, 'filter') && Arr::get($data, 'filter') == 'season') {
            if (Arr::has($data, 'linkedLeague')) {
                $allDivisions = $this->linkedLeagueRepository->getChildLinkedLeagues($data['linkedLeague']);

                $allDivisions[] = $this->linkedLeagueRepository->getParentLinkedLeagueDivision($data['linkedLeague']);

                $divisionTeamsWeek = $this->weekScore($allDivisions)->pluck('total_point', 'teamId');
                $divisionTeamsMonth = $this->monthScore($allDivisions)->pluck('total_point', 'teamId');
            } else {
                $divisions[] = $division->id;
                $divisionTeamsWeek = $this->weekScore($divisions)->pluck('total_point', 'teamId');
                $divisionTeamsMonth = $this->monthScore($divisions)->pluck('total_point', 'teamId');
            }
        }

        if (! $divisionTeamsAll->count()) {
            return [];
        }

        if (Arr::has($data, 'linkedLeague')) {
            $division = Division::find($data['linkedLeague']);
        }

        // $playerPositions = TeamPointsPositionEnum::toSelectArray();
        $playerPositions = PositionsEnum::toSelectArray();
        $divisionPoints = $this->getDivisionPoints($division, $playerPositions);

        $divisionTeams = collect();
        foreach ($divisionTeamsAll->groupBy('teamId') as $key =>  $points) {
            $team = [];
            $team['total_goal'] = 0;
            $team['total_assist'] = 0;
            $team['total_clean_sheet'] = 0;
            $team['total_conceded'] = 0;
            $team['total_appearance'] = 0;
            $team['total_own_goal'] = 0;
            $team['total_red_card'] = 0;
            $team['total_yellow_card'] = 0;
            $team['total_penalty_missed'] = 0;
            $team['total_penalty_saved'] = 0;
            $team['total_goalkeeper_save'] = 0;
            $team['total_club_win'] = 0;
            $team['total_point'] = 0;

            foreach ($points as $point) {
                $goalConceded = isset($divisionPoints[$point->position][EventsEnum::GOAL_CONCEDED]) ? $divisionPoints[$point->position][EventsEnum::GOAL_CONCEDED] : 0;
                $cleanSheet = isset($divisionPoints[$point->position][EventsEnum::CLEAN_SHEET]) ? $divisionPoints[$point->position][EventsEnum::CLEAN_SHEET] : 0;
                $appearance = isset($divisionPoints[$point->position][EventsEnum::APPEARANCE]) ? $divisionPoints[$point->position][EventsEnum::APPEARANCE] : 0;

                if ($cleanSheet === 0) {
                    $point->total_clean_sheet = 0;
                }

                if ($goalConceded === 0) {
                    $point->total_conceded = 0;
                }

                if ($appearance === 0) {
                    $point->total_appearance = 0;
                }

                $team['teamName'] = $point->teamName;
                $team['teamId'] = $point->teamId;
                $team['divisionId'] = $point->divisionId;
                $team['total_goal'] = $team['total_goal'] + $point->total_goal;
                $team['total_assist'] = $team['total_assist'] + $point->total_assist;
                $team['total_clean_sheet'] = $team['total_clean_sheet'] + $point->total_clean_sheet;
                $team['total_conceded'] = $team['total_conceded'] + $point->total_conceded;
                $team['total_appearance'] = $team['total_appearance'] + $point->total_appearance;
                $team['total_own_goal'] = $team['total_own_goal'] + $point->total_own_goal;
                $team['total_red_card'] = $team['total_red_card'] + $point->total_red_card;
                $team['total_yellow_card'] = $team['total_yellow_card'] + $point->total_yellow_card;
                $team['total_penalty_missed'] = $team['total_penalty_missed'] + $point->total_penalty_missed;
                $team['total_penalty_saved'] = $team['total_penalty_saved'] + $point->total_penalty_saved;
                $team['total_goalkeeper_save'] = $team['total_goalkeeper_save'] + $point->total_goalkeeper_save;
                $team['total_club_win'] = $team['total_club_win'] + $point->total_club_win;
                $team['total_point'] = $team['total_point'] + $point->total_point;
                $team['first_name'] = $point->first_name;
                $team['last_name'] = $point->last_name;
                $team['manager_email'] = $point->manager_email;
            }

            if (Arr::has($data, 'filter') && Arr::get($data, 'filter') === 'season') {
                $team['total_point_week'] = $divisionTeamsWeek->get($team['teamId'], 0);
                $team['total_point_month'] = $divisionTeamsMonth->get($team['teamId'], 0);
            }

            $divisionTeams[] = $team;
        }

        $divisionTeamsData = $divisionTeams->sortByDesc('total_assist')
                        ->sortByDesc('total_goal')
                        ->sortByDesc('total_point')
                        ->values()
                        ->all();

        $allTeams = array_column($divisionTeamsData, 'teamId');
        $allTeams = $this->repository->getTeamsById($allTeams);

        $divisionTeamsData = collect($divisionTeamsData)->map(function ($value, $key) use ($allTeams) {
            $team = $allTeams->where('id', $value['teamId'])->first();
            $value['crest'] = $team->getCrestImageThumb();

            return $value;
        });

        if (Arr::get($data, 'filter') == 'season') {
            $adjustments = $this->repository->getPointAdjustments($division);

            foreach ($divisionTeamsData as $key => $divisionTeam) {
                if (isset($adjustments[$divisionTeam['teamId']]['regular'])) {
                    $divisionTeam['total_point'] += $adjustments[$divisionTeam['teamId']]['regular'];
                }
                $divisionTeamsData[$key] = $divisionTeam;
            }
        }

        $divisionTeamsData = $divisionTeamsData->toArray();

        array_multisort(array_column($divisionTeamsData, 'total_point'), SORT_DESC,
                        array_column($divisionTeamsData, 'total_goal'), SORT_DESC,
                        array_column($divisionTeamsData, 'total_assist'), SORT_DESC,
                        $divisionTeamsData);

        $position = 0;
        $temp = 0;
        foreach ($divisionTeamsData as $key => $value) {
            $totalPoints = $value['total_point'];
            $totalGoal = $value['total_goal'];
            $totalAssist = $value['total_assist'];

            if ($key > 0) {
                if ($totalPoints == $divisionTeamsData[$key - 1]['total_point'] && $totalGoal == $divisionTeamsData[$key - 1]['total_goal'] && $totalAssist == $divisionTeamsData[$key - 1]['total_assist']) {
                    $temp++;
                } else {
                    $position++;
                    $position = $position + $temp;
                    $temp = 0;
                }
            } else {
                $position++;
                $position = $position + $temp;
                $temp = 0;
            }
            $divisionTeamsData[$key]['league_position'] = $position;
        }

        return $divisionTeamsData;
    }

    public function getHallFameData($division)
    {
        $divisions[] = $division->id;

        $season = Season::getLatestSeason();

        $fixturesStart = Fixture::where('season_id', $season)->orderBy('date_time', 'asc')->first();

        $count = Fixture::where('date_time', '>', now())->whereRaw('DATE(date_time) <= LAST_DAY(now())')->count();

        $months = collect();
        if($fixturesStart) {

            if ($count > 0) {
                $months = carbon_get_months_between_dates($fixturesStart->date_time, date_create('last day of -1 month')->format('Y-m-d'));
            } else {
                $months = carbon_get_months_between_dates($fixturesStart->date_time, now());
            }
        }

        $monthlyPoints = [];
        foreach ($months as $monthKey => $monthVal) {
            $data['startDate'] = $monthVal['startDate'];
            $data['endDate'] = $monthVal['endDate'];
            $monthlyPoints[] = $this->repository->getDivisionLeagueStandingsTeamsScoresDateWise($divisions, $data)->pluck('teamId')->first();
        }

        return array_count_values($monthlyPoints);
    }

    public function getLeagueTitleData($division)
    {
        $divisions[] = $division->id;

        return $this->repository->getLeagueTitle($division);
    }

    public function getDivisionFaCupTeamsScores($division, $data = null)
    {
        return $this->repository->getDivisionFaCupTeamsScores($division, $data);
    }

    public function getUserLeagues($user)
    {
        return $this->repository->getUserLeagues($user);
    }

    public function updateDivisionsPoints($division, $data)
    {
        return $this->repository->updateDivisionsPoints($division, $data);
    }

    public function updateDivisionsEuropeanCups($division, $data)
    {
        return $this->repository->updateDivisionsEuropeanCups($division, $data);
    }

    public function teamApprovals($division)
    {
        return $this->repository->teamApprovals($division);
    }

    public function updateDivisionPoint($divisionPoint, $data)
    {
        if ($data['columnName'] == 'defender') {
            $divisionPoint->fill([
                'centre_back' => $data['columnValue'],
                'full_back' => $data['columnValue'],
            ]);
        } else {
            $divisionPoint->fill([
                $data['columnName'] => $data['columnValue'],
            ]);
        }

        return $this->repository->updateDivisionPoint($divisionPoint, $data);
    }

    public function adjustSize($size)
    {
        $sizes = collect([16, 14, 12, 10, 8, 6])->sort();

        return $sizes->first(function ($value) use ($size) {
            return $value >= $size;
        });
    }

    public function getTeamsScores($data)
    {
        return $this->repository->getTeamsScores($data);
    }

    public function isCompetition($division, $consumer, $tournament)
    {
        return $this->repository->isCompetition($division, $consumer, $tournament);
    }

    public function getChildParentDivisions($division)
    {
        $childDivisions = $division->divisons;
        $parentDivision = $division->parentDivision;

        return $childDivisions->push($parentDivision)->filter()->pluck('name', 'id');
    }

    public function updateDivisionChampionEuropa($season)
    {
        $divisionTopTeams = $this->repository->getDivisionTopTeams($season);
        if ($divisionTopTeams->count()) {
            $teams = [];
            foreach ($divisionTopTeams as $key => $value) {
                $teams[$value->division_id][$value->team_id] = $value->points;
            }

            foreach ($teams as $teamkey => $teamValue) {
                $i = 0;

                foreach ($teamValue as $poinitKey => $poinitValue) {
                    if ($i == 0) {
                        $this->repository->updateDivisionChampionEuropaTeam($teamkey, 'champions_league_team', $poinitKey);
                    } elseif ($i < 3) {
                        $this->repository->updateDivisionChampionEuropaTeam($teamkey, 'europa_league_team_'.$i, $poinitKey);
                    }
                    $i++;
                }
            }
        }
    }

    public function allowCustomCup($division)
    {
        if ($division->package->allow_custom_cup == YesNoEnum::YES) {
            return true;
        }

        return false;
    }

    public function updateDivisionChampionEuropaTeam($division, $data)
    {
        return $this->repository->updateDivisionChampionEuropaTeam($division->id, $data['divisionColumn'], $data['team']);
    }

    public function getUserPackage($user)
    {
        return $this->repository->getUserPackage($user);
    }

    public function getSocialLeagues()
    {
        return $this->repository->getSocialLeagues();
    }

    public function getDivisionPoints($division, $positionsEnums)
    {
        $pointCalc = [];
        foreach ($positionsEnums as $positionsEnumKey => $positionsEnum) {
            $playerPosition = player_position_full($positionsEnum);

            if ($playerPosition == self::DEFENSIVE_MID_FIELDER) {
                $playerPosition = ($division->IsDMFOn()) ? self::DEFENSIVE_MID_FIELDER : self::MID_FIELDER;
            }

            if ($playerPosition == self::CENTRE_BACK) {
                $playerPosition = ($division->IsMergeDefendersOn()) ? self::FULL_BACK : self::CENTRE_BACK;
            }

            $pointCalc[$playerPosition][EventsEnum::GOAL] = $division->getOptionValue($positionsEnumKey, EventsEnum::GOAL);
            $pointCalc[$playerPosition][EventsEnum::ASSIST] = $division->getOptionValue($positionsEnumKey, EventsEnum::ASSIST);
            $pointCalc[$playerPosition][EventsEnum::CLEAN_SHEET] = $division->getOptionValue($positionsEnumKey, EventsEnum::CLEAN_SHEET);
            $pointCalc[$playerPosition][EventsEnum::GOAL_CONCEDED] = $division->getOptionValue($positionsEnumKey, EventsEnum::GOAL_CONCEDED);
            $pointCalc[$playerPosition][EventsEnum::APPEARANCE] = $division->getOptionValue($positionsEnumKey, EventsEnum::APPEARANCE);
            $pointCalc[$playerPosition][EventsEnum::CLUB_WIN] = $division->getOptionValue($positionsEnumKey, EventsEnum::CLUB_WIN);
            $pointCalc[$playerPosition][EventsEnum::YELLOW_CARD] = $division->getOptionValue($positionsEnumKey, EventsEnum::YELLOW_CARD);
            $pointCalc[$playerPosition][EventsEnum::RED_CARD] = $division->getOptionValue($positionsEnumKey, EventsEnum::RED_CARD);
            $pointCalc[$playerPosition][EventsEnum::OWN_GOAL] = $division->getOptionValue($positionsEnumKey, EventsEnum::OWN_GOAL);
            $pointCalc[$playerPosition][EventsEnum::PENALTY_MISSED] = $division->getOptionValue($positionsEnumKey, EventsEnum::PENALTY_MISSED);
            $pointCalc[$playerPosition][EventsEnum::PENALTY_SAVE] = $division->getOptionValue($positionsEnumKey, EventsEnum::PENALTY_SAVE);
            $pointCalc[$playerPosition][EventsEnum::GOALKEEPER_SAVE_X5] = $division->getOptionValue($positionsEnumKey, EventsEnum::GOALKEEPER_SAVE_X5);
        }

        return $pointCalc;
    }

    public function leagueStandingColumnHideShow($division)
    {
        $playerPositions = PositionsEnum::toSelectArray();
        $events = EventsEnum::toSelectArray();
        $divisionPoints = collect($this->getDivisionPoints($division, $playerPositions));
        $packagePoints = collect($this->packageService->getPackagePoints($division->package, $playerPositions));
        $columns = [];

        foreach ($events as $key => $event) {
            $count = $divisionPoints->where($key, '!=', null)->where($key, '!=', 0)->count();
            if ($count == 0) {
                $count = $packagePoints->where($key, '!=', null)->where($key, '!=', 0)->count();
            }
            $columns[$key] = $count;
        }

        return $columns;
    }

    public function getRulesData($division)
    {
        return $this->repository->getRulesData($division);
    }

    public function getPointsData($division)
    {
        return $this->repository->getPointsData($division);
    }

    public function getCustomDivisionPoints($division, $event = null)
    {
        return $this->repository->getCustomDivisionPoints($division, $event);
    }

    public function updateIsViewedPackageSelection($division)
    {
        return $this->repository->updateIsViewedPackageSelection($division);
    }

    public function updatePackage($division, $data, $dbPackageId)
    {
        return $this->repository->updatePackage($division, $data, $dbPackageId);
    }

    public function updatePrizePack($division, $data)
    {
        return $this->repository->updatePrizePack($division, $data);
    }

    public function updateFreePlaceTeam($division)
    {
        return $this->repository->updateFreePlaceTeam($division);
    }

    public function getLeagueType()
    {
        return $this->packageRepository->getLeagueType();
    }

    public function checkNewUserteam($managerId)
    {
        return $this->repository->checkNewUserteam($managerId);
    }

    public function checkNewUserteamPrevious($managerId)
    {
        return $this->repository->checkNewUserteamPrevious($managerId);
    }

    public function getPlayerScoresDivisionWeekWise($division, $data)
    {
        $data['startDate'] = now()->startOfWeek();
        $data['endDate'] = now()->endOfWeek();

        $gameweek = $this->gameWeekService->getActiveGameWeek();

        if (! $gameweek) {
            $gameweek = $this->gameWeekService->getLastActiveGameWeek();

            if ($gameweek) {
                $data['startDate'] = $gameweek->start;
                $data['endDate'] = $gameweek->end;
            }
        } else {
            $data['startDate'] = $gameweek->start;
            $data['endDate'] = $gameweek->end;
        }

        $players = $this->playerRepository->getPlayerScoresDivisionDateWise($division, $data);

        return $this->calculatePlayerPoints($division, $players);
    }

    public function getPlayerScoresDivisionMonthWise($division, $data)
    {
        $data['startDate'] = now()->startOfMonth();
        $data['endDate'] = now()->endOfMonth();

        $players = $this->playerRepository->getPlayerScoresDivisionDateWise($division, $data);

        return $this->calculatePlayerPoints($division, $players);
    }

    public function calculatePlayerPoints($division, $players)
    {
        $playerPositions = PositionsEnum::toSelectArray();
        $divisionPoints = $this->getDivisionPoints($division, $playerPositions);

        $players = $players->each(function ($item, $key) use ($divisionPoints) {
            $goal = isset($divisionPoints[$item->position][EventsEnum::GOAL]) && $divisionPoints[$item->position][EventsEnum::GOAL] ? $divisionPoints[$item->position][EventsEnum::GOAL] : 0;
            $assist = isset($divisionPoints[$item->position][EventsEnum::ASSIST]) && $divisionPoints[$item->position][EventsEnum::ASSIST] ? $divisionPoints[$item->position][EventsEnum::ASSIST] : 0;
            $goalConceded = isset($divisionPoints[$item->position][EventsEnum::GOAL_CONCEDED]) && $divisionPoints[$item->position][EventsEnum::GOAL_CONCEDED] ? $divisionPoints[$item->position][EventsEnum::GOAL_CONCEDED] : 0;
            $cleanSheet = isset($divisionPoints[$item->position][EventsEnum::CLEAN_SHEET]) && $divisionPoints[$item->position][EventsEnum::CLEAN_SHEET] ? $divisionPoints[$item->position][EventsEnum::CLEAN_SHEET] : 0;
            $appearance = isset($divisionPoints[$item->position][EventsEnum::APPEARANCE]) && $divisionPoints[$item->position][EventsEnum::APPEARANCE] ? $divisionPoints[$item->position][EventsEnum::APPEARANCE] : 0;
            $clubWin = isset($divisionPoints[$item->position][EventsEnum::CLUB_WIN]) && $divisionPoints[$item->position][EventsEnum::CLUB_WIN] ? $divisionPoints[$item->position][EventsEnum::CLUB_WIN] : 0;
            $redCard = isset($divisionPoints[$item->position][EventsEnum::RED_CARD]) && $divisionPoints[$item->position][EventsEnum::RED_CARD] ? $divisionPoints[$item->position][EventsEnum::RED_CARD] : 0;
            $yellowCard = isset($divisionPoints[$item->position][EventsEnum::YELLOW_CARD]) && $divisionPoints[$item->position][EventsEnum::YELLOW_CARD] ? $divisionPoints[$item->position][EventsEnum::YELLOW_CARD] : 0;
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

            $item->setAttribute('total', $total);

            unset($item->total_goal, $item->total_assist, $item->total_goal_against, $item->total_clean_sheet,$item->total_game_played,$item->total_own_goal,$item->total_red_card,$item->total_yellow_card,$item->total_penalty_missed,$item->total_penalty_saved,$item->total_goalkeeper_save,$item->total_club_win,$item->position);
        });

        return $players->keyBy('id')->toArray();
    }

    public function headToHeadActiveGameWeek($gameweeks)
    {
        $activeWeekId = 0;

        if ($gameweeks) {
            $activeWeek = $gameweeks->first(function ($value, $key) {
                return $value->start->lte(now()) && $value->end->gte(now());
            });

            if (! $activeWeek) {
                $activeWeek = $gameweeks->first(function ($value, $key) {
                    return $value->start->gte(now());
                });
            }

            $activeWeekId = $activeWeek ? $activeWeek->id : 0;
        }

        return $activeWeekId;
    }

    public function leagueStandingActiveGameWeek($gameweeks)
    {
        $activeWeekId = 0;
        if ($gameweeks) {
            $activeWeek = $gameweeks->where('start', '<=', now())->where('end', '>=', now());
            if ($activeWeek->count()) {
                $activeWeekId = $activeWeek->first()->id;
            } else {
                $activeWeek = $gameweeks->where('start', '<=', now())->last();
                $activeWeekId = $activeWeek ? $activeWeek->id : $gameweeks->last()->id;
            }
        }

        return $activeWeekId;
    }

    public function getCurrentSeasonPackages()
    {
        return $this->repository->getCurrentSeasonPackages();
    }

    public function getMonths($division)
    {
        $season_id = Season::getLatestSeason();
        
        $fixturesStart = Fixture::where('season_id', $season_id)->orderBy('date_time', 'asc')->first();
        $fixturesEnd = Fixture::where('season_id', $season_id)->orderBy('date_time', 'desc')->first();

        if($fixturesStart && $fixturesEnd) {
            $start_date_time = $fixturesStart->date_time;
            $end_date_time = $fixturesEnd->date_time;
        } else {
            $season = Season::find($season_id);
            $start_date_time = $season->date_time;
            $end_date_time = $season->date_time;
        }

        $months = carbon_get_months_between_dates($start_date_time, $end_date_time);


        return $months;
    }

    public function getCoChairman($division)
    {
        $consumers = $division->divisionTeams->load('consumer')->pluck('consumer');
        // $merged = $consumers->merge($division->coChairmen);

        // $consumers = $merged->flatten()->unique(function ($consumer) {
        //     if ($consumer) {
        //         return $consumer->id;
        //     }
        // });

        return $consumers;
    }
}
