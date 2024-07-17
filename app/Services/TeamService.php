<?php

namespace App\Services;

use App\Enums\CompetitionEnum;
use App\Enums\EventsEnum;
use App\Enums\PositionsEnum;
use App\Enums\YesNoEnum;
use App\Jobs\RecalculatePointsForTeam;
use App\Mail\Manager\Divisions\SocialLeagueJoinEmail;
use App\Mail\Manager\Divisions\TeamCreateEmail;
use App\Models\CmdSetting;
use App\Models\Team;
use App\Repositories\TeamLineupRepository;
use App\Repositories\TeamRepository;
use Intervention\Image\ImageManager;
use Mail;

class TeamService
{
    const LINE_UP = 'lineup';
    const BENCH = 'bench';
    const LINE_UP_BENCH = 'both';

    /**
     * The team repository instance.
     *
     * @var TeamRepository
     */
    protected $repository;

    /**
     * The team lineup instance.
     *
     * @var TeamRepository
     */
    protected $lineupRepo;

    /**
     * Create a new service instance.
     *
     * @param GameWeekService $gameWeekService
     */
    protected $gameWeekService;

    /**
     * The image manager instance.
     *
     * @var ImageManager
     */
    protected $images;

    /**
     * Create a new service instance.
     *
     * @param TeamRepository $repository
     */
    public function __construct(TeamRepository $repository, ImageManager $images, TeamLineupRepository $lineupRepo, GameWeekService $gameWeekService)
    {
        $this->repository = $repository;
        $this->images = $images;
        $this->lineupRepo = $lineupRepo;
        $this->gameWeekService = $gameWeekService;
    }

    public function create($data)
    {
        $team = $this->repository->create($data);

        $tiePreferenceService = app(TiePreferenceService::class);
        $tiePreferenceService->tieCreate($team);

        return $team;
    }

    public function update($team, $data)
    {
        return $this->repository->update($team, $data);
    }

    public function updateCrest($team, $data)
    {
        return $this->repository->updateCrest($team, $data);
    }

    public function updatePitch($team, $data)
    {
        return $this->repository->updatePitch($team, $data);
    }

    public function updateTeamName($team, $data)
    {
        return $this->repository->updateTeamName($team, $data);
    }

    public function getDivisions($season)
    {
        return $this->repository->getDivisions($season);
    }

    public function getConsumers()
    {
        return $this->repository->getConsumers();
    }

    public function getManager($team)
    {
        return $this->repository->getManager($team);
    }

    public function getPredefinedCrests()
    {
        return $this->repository->getPredefinedCrests();
    }

    public function getPitches()
    {
        return $this->repository->getPitches();
    }

    public function getTeamSeasons()
    {
        return $this->repository->getTeamSeasons();
    }

    public function crestDestroy($team)
    {
        return $this->repository->crestDestroy($team);
    }

    public function approveTeam($team)
    {
        return $this->repository->approveTeam($team);
    }

    public function ignoreTeam($team)
    {
        return $this->repository->ignoreTeam($team);
    }

    public function validateTeamName($team_name)
    {
        return $this->repository->validateTeamName($team_name);
    }

    public function getPendingRequests($division)
    {
        return $this->repository->getDivisionPendingTeams($division);
    }

    public function lineup($division, $team)
    {
        return $this->lineupRepo->getLineupData($division, $team);
    }

    public function getPlayerStats($team)
    {
        return $this->lineupRepo->getPlayerStats($team);
    }

    public function getTeamForCustomCup($division)
    {
        return $this->repository->getTeamForCustomCup($division);
    }

    public function getPlayerStatsBySeason($team, $player, $season)
    {
        return $this->lineupRepo->getPlayerStatsBySeason($team, $player, $season);
    }

    public function getLatestTeamCrests()
    {
        return $this->repository->getLatestTeamCrests();
    }

    public function delete($team)
    {
        return $this->repository->delete($team);
    }

    public function markAsUnPaid($team)
    {
        return $this->repository->markAsUnPaid($team);
    }

    public function markAsPaid($team)
    {
        return $this->repository->markAsPaid($team);
    }

    public function sendTeamConformationMail($team)
    {
        $manager = $team->consumer->user;
        Mail::to($manager->email)->send(new TeamCreateEmail($team));
        if ($team->divisionTeam->division->package->private_league == YesNoEnum::NO) {
            Mail::to($manager->email)->send(new SocialLeagueJoinEmail($team));
        }
        unset($team->fristName);
        unset($team->Season);
    }

    public function getDivisionTeamsDetails($division)
    {
        $defaultSquadSize = $division->getOptionValue('default_squad_size');
        $divisionTeams = $this->repository->getDivisionTeamsDetails($division);

        return $divisionTeams->filter(function ($value, $key) use ($defaultSquadSize,$division) {
            $value->setAttribute('crest', $value->getCrestImageThumb());
            $value->setAttribute('defaultSquadSize', $defaultSquadSize);
            $value->setAttribute('monthly_quota_used', $division->getOptionValue('monthly_free_agent_transfer_limit') - $value->monthly_quota_used);
            $value->setAttribute('season_quota_used', $division->getOptionValue('season_free_agent_transfer_limit') - $value->season_quota_used);
            unset($value['transferBudget']);
            $value->setAttribute('monthly_free_agent_transfer_limit', $division->getOptionValue('monthly_free_agent_transfer_limit'));
            $value->setAttribute('season_free_agent_transfer_limit', $division->getOptionValue('season_free_agent_transfer_limit'));

            return $value->setAttribute('defaultSquadSize', $defaultSquadSize);
        });
    }

    public function teamsBudgetUpdate($division, $data)
    {
        return $this->repository->teamsBudgetUpdate($division, $data);
    }

    public function recalculatePoints($team, $email)
    {
        // RecalculatePointsForTeam::dispatch($team, $email);
        unset($command);
        $command['type'] = 'recalculate_points_for_team';
        $command['command'] = 'recalculate:points-for-team';
        $command['payload'] = json_encode(['team' => $team->id, 'email' => $email]);

        $response = CmdSetting::create($command);
    }

    public function calculatePoints($division, $players, $team)
    {
        $divisionService = app(DivisionService::class);
        $playerPositions = PositionsEnum::toSelectArray();
        $divisionPoints = $divisionService->getDivisionPoints($division, $playerPositions);

        return $players = $players->each(function ($item, $key) use ($divisionPoints) {
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

            $item->goals = $goal === 0 ? 0 : $item->goals;
            $item->assists = $assist === 0 ? 0 : $item->assists;
            $item->goal_against = $goalConceded === 0 ? 0 : $item->goal_against;
            $item->clean_sheets = $cleanSheet === 0 ? 0 : $item->clean_sheets;
            $item->penalty_missed = $penaltyMissed === 0 ? 0 : $item->penalty_missed;
            $item->penalty_saved = $penaltySave === 0 ? 0 : $item->penalty_saved;
            $item->goalkeeper_save = $goalkeeperSave === 0 ? 0 : $item->goalkeeper_save;
            $item->red_card = $redCard === 0 ? 0 : $item->red_card;
            $item->yellow_card = $yellowCard === 0 ? 0 : $item->yellow_card;
            $item->own_goal = $ownGoal === 0 ? 0 : $item->own_goal;
            $item->club_win = $clubWin === 0 ? 0 : $item->club_win;

            $total = 0;
            $total += $goal * $item->goals;
            $total += $assist * $item->assists;
            $total += $goalConceded * $item->goal_against;
            $total += $cleanSheet * $item->clean_sheets;
            $total += $appearance * $item->played;
            $total += $penaltyMissed * $item->penalty_missed;
            $total += $penaltySave * $item->penalty_saved;
            $total += $goalkeeperSave * $item->goalkeeper_save;
            $total += $redCard * $item->red_card;
            $total += $yellowCard * $item->yellow_card;
            $total += $ownGoal * $item->own_goal;
            $total += $clubWin * $item->club_win;

            $item->position = player_position_short($item->position);
            $item->setAttribute('appearance', $appearance);
            $item->setAttribute('total', $total);
        });
    }

    public function calculateLineupBenchPoints($division, $team, $lineupPoints, $benchPoints)
    {
        $positionOrder = $division->getPositionOrder();

        $totalPoints = $lineupPoints->each(function ($item, $key) use ($division, $benchPoints, $positionOrder) {
            if ($benchPoints->has($item->id)) {
                $item->setAttribute('lost_played', $benchPoints[$item->id]->played);
                $item->setAttribute('lost_goal', $benchPoints[$item->id]->goals);
                $item->setAttribute('lost_assists', $benchPoints[$item->id]->assists);
                $item->setAttribute('lost_clean_sheets', $benchPoints[$item->id]->clean_sheets);
                $item->setAttribute('lost_goal_against', $benchPoints[$item->id]->goal_against);
                $item->setAttribute('lost_appearance', $benchPoints[$item->id]->appearance);
                $item->setAttribute('lost_penalty_missed', $benchPoints[$item->id]->penalty_missed);
                $item->setAttribute('lost_penalty_saved', $benchPoints[$item->id]->penalty_saved);
                $item->setAttribute('lost_goalkeeper_save', $benchPoints[$item->id]->goalkeeper_save);
                $item->setAttribute('lost_red_card', $benchPoints[$item->id]->red_card);
                $item->setAttribute('lost_yellow_card', $benchPoints[$item->id]->yellow_card);
                $item->setAttribute('lost_own_goal', $benchPoints[$item->id]->own_goal);
                $item->setAttribute('lost_club_win', $benchPoints[$item->id]->club_win);
                $item->setAttribute('lost_total', $benchPoints[$item->id]->total);
            } else {
                $item->setAttribute('lost_played', 0);
                $item->setAttribute('lost_goal', 0);
                $item->setAttribute('lost_assists', 0);
                $item->setAttribute('lost_clean_sheets', 0);
                $item->setAttribute('lost_goal_against', 0);
                $item->setAttribute('lost_appearance', 0);
                $item->setAttribute('lost_penalty_missed', 0);
                $item->setAttribute('lost_penalty_saved', 0);
                $item->setAttribute('lost_goalkeeper_save', 0);
                $item->setAttribute('lost_red_card', 0);
                $item->setAttribute('lost_yellow_card', 0);
                $item->setAttribute('lost_own_goal', 0);
                $item->setAttribute('lost_club_win', 0);
                $item->setAttribute('lost_total', 0);
            }
            $pos = $division->getPositionShortCode($item->position);
            //$item->setAttribute('playerPositionShort', $pos);
            $item->setAttribute('positionOrder', isset($positionOrder[$item->position]) ? $positionOrder[$item->position] : 0);
        });

        $benchPoints->each(function ($item, $key) use ($division, $totalPoints, $positionOrder) {
            if (! $totalPoints->where('id', $item->id)->count()) {
                $pos = $division->getPositionShortCode($item->position);

                $item->setAttribute('lost_played', 0);
                $item->setAttribute('lost_goal', 0);
                $item->setAttribute('lost_assists', 0);
                $item->setAttribute('lost_clean_sheets', 0);
                $item->setAttribute('lost_goal_against', 0);
                $item->setAttribute('lost_appearance', 0);
                $item->setAttribute('lost_penalty_missed', 0);
                $item->setAttribute('lost_penalty_saved', 0);
                $item->setAttribute('lost_goalkeeper_save', 0);
                $item->setAttribute('lost_red_card', 0);
                $item->setAttribute('lost_yellow_card', 0);
                $item->setAttribute('lost_own_goal', 0);
                $item->setAttribute('lost_club_win', 0);
                $item->setAttribute('lost_total', 0);

                //$item->setAttribute('playerPositionShort', $pos);
                $item->setAttribute('positionOrder', isset($positionOrder[$item->position]) ? $positionOrder[$item->position] : 0);
                $totalPoints->push($item);
            }
        });

        return $totalPoints;
    }

    public function mergePremeirAndFacup($premierPoints, $faPoints)
    {
        return $premierPoints->map(function ($item, $key) use ($faPoints) {
            $item->setAttribute('fa_played', $faPoints->where('id', $item->id)->first()->played);
            $item->setAttribute('fa_goals', $faPoints->where('id', $item->id)->first()->goals);
            $item->setAttribute('fa_assists', $faPoints->where('id', $item->id)->first()->assists);
            $item->setAttribute('fa_clean_sheets', $faPoints->where('id', $item->id)->first()->clean_sheets);
            $item->setAttribute('fa_goal_against', $faPoints->where('id', $item->id)->first()->goal_against);
            $item->setAttribute('fa_own_goal', $faPoints->where('id', $item->id)->first()->own_goal);
            $item->setAttribute('fa_red_card', $faPoints->where('id', $item->id)->first()->red_card);
            $item->setAttribute('fa_yellow_card', $faPoints->where('id', $item->id)->first()->yellow_card);
            $item->setAttribute('fa_penalty_missed', $faPoints->where('id', $item->id)->first()->penalty_missed);
            $item->setAttribute('fa_penalty_saved', $faPoints->where('id', $item->id)->first()->penalty_saved);
            $item->setAttribute('fa_goalkeeper_save', $faPoints->where('id', $item->id)->first()->goalkeeper_save);
            $item->setAttribute('fa_club_win', $faPoints->where('id', $item->id)->first()->club_win);
            $item->setAttribute('fa_total', $faPoints->where('id', $item->id)->first()->total);

            $item->setAttribute('fa_lost_played', $faPoints->where('id', $item->id)->first()->lost_played);
            $item->setAttribute('fa_lost_goals', $faPoints->where('id', $item->id)->first()->lost_goal);
            $item->setAttribute('fa_lost_assists', $faPoints->where('id', $item->id)->first()->lost_assists);
            $item->setAttribute('fa_lost_clean_sheets', $faPoints->where('id', $item->id)->first()->lost_clean_sheets);
            $item->setAttribute('fa_lost_goal_against', $faPoints->where('id', $item->id)->first()->lost_goal_against);
            $item->setAttribute('fa_lost_own_goal', $faPoints->where('id', $item->id)->first()->lost_own_goal);
            $item->setAttribute('fa_lost_red_card', $faPoints->where('id', $item->id)->first()->lost_red_card);
            $item->setAttribute('fa_lost_yellow_card', $faPoints->where('id', $item->id)->first()->lost_yellow_card);
            $item->setAttribute('fa_lost_penalty_missed', $faPoints->where('id', $item->id)->first()->lost_penalty_missed);
            $item->setAttribute('fa_lost_penalty_saved', $faPoints->where('id', $item->id)->first()->lost_penalty_saved);
            $item->setAttribute('fa_lost_goalkeeper_save', $faPoints->where('id', $item->id)->first()->lost_goalkeeper_save);
            $item->setAttribute('fa_lost_club_win', $faPoints->where('id', $item->id)->first()->lost_club_win);

            return $item->setAttribute('fa_lost_total', $faPoints->where('id', $item->id)->first()->lost_total);
        });
    }

    public function playerHistory($division, $team)
    {
        $premierPoints = $this->playerHistoryPoints($division, $team, CompetitionEnum::PREMIER_LEAGUE);
        $faPoints = $this->playerHistoryPoints($division, $team, CompetitionEnum::FA_CUP);
        $premierPoints = $this->mergePremeirAndFacup($premierPoints, $faPoints);
        $premierPoints = $premierPoints->sortBy('player_last_name')
                        ->sortBy('positionOrder');

        return $premierPoints->values()->all();
    }

    public function playerHistoryPoints($division, $team, $leagueType)
    {
        $lineupPoints = $this->repository->playerData($division, $team, self::LINE_UP, $leagueType);
        $lineupPoints = $this->calculatePoints($division, $lineupPoints, $team);
        $benchPoints = $this->repository->playerData($division, $team, self::BENCH, $leagueType);
        $benchPoints = $this->calculatePoints($division, $benchPoints, $team);
        $benchPoints = $benchPoints->keyBy('id');

        return $this->calculateLineupBenchPoints($division, $team, $lineupPoints, $benchPoints);
    }

    public function soldPlayers($team, $division)
    {
        $pl = $this->repository->soldPlayers($division, $team, CompetitionEnum::PREMIER_LEAGUE);
        $fc = $this->repository->soldPlayers($division, $team, CompetitionEnum::FA_CUP);

        $playersPremier = $this->calculatePoints($division, $pl, $team);
        $playersFacup = $this->calculatePoints($division, $fc, $team);

        $positionOrder = $division->getPositionOrder();

        $totalPoints = $playersPremier->each(function ($item, $key) use ($division, $positionOrder, $playersFacup) {
            $pos = $division->getPositionShortCode($item->position);
            $item->setAttribute('positionOrder', isset($positionOrder[$item->position]) ? $positionOrder[$item->position] : 0);

            $item->setAttribute('fa_played', $playersFacup->where('id', $item->id)->first()->played);
            $item->setAttribute('fa_goals', $playersFacup->where('id', $item->id)->first()->goals);
            $item->setAttribute('fa_assists', $playersFacup->where('id', $item->id)->first()->assists);
            $item->setAttribute('fa_clean_sheets', $playersFacup->where('id', $item->id)->first()->clean_sheets);
            $item->setAttribute('fa_goal_against', $playersFacup->where('id', $item->id)->first()->goal_against4);
            $item->setAttribute('fa_own_goal', $playersFacup->where('id', $item->id)->first()->own_goal);
            $item->setAttribute('fa_red_card', $playersFacup->where('id', $item->id)->first()->red_card);
            $item->setAttribute('fa_yellow_card', $playersFacup->where('id', $item->id)->first()->yellow_card);
            $item->setAttribute('fa_penalty_missed', $playersFacup->where('id', $item->id)->first()->penalty_missed);
            $item->setAttribute('fa_penalty_saved', $playersFacup->where('id', $item->id)->first()->penalty_saved);
            $item->setAttribute('fa_goalkeeper_save', $playersFacup->where('id', $item->id)->first()->goalkeeper_save);
            $item->setAttribute('fa_club_win', $playersFacup->where('id', $item->id)->first()->club_win);

            return $item->setAttribute('fa_total', $playersFacup->where('id', $item->id)->first()->total);
        });

        $sorted = $totalPoints->sortBy('player_last_name')->sortBy('positionOrder');

        return $sorted->values()->all();
    }

    public function getTeamPlayerPoints($division, $teamId)
    {
        $packagePointCalculation = config('fantasy.default_point_scoring');

        return $this->calculatePlayerPoints($division, $teamId, $packagePointCalculation);
    }

    public function getTeamDivisionPoints($division, $teamId)
    {
        $divisionService = app(DivisionService::class);
        $playerPositions = PositionsEnum::toSelectArray();
        $divisionPoints = $divisionService->getDivisionPoints($division, $playerPositions);

        $tempDivisionPoints = [];
        foreach ($divisionPoints as $key => $value) {
            $tempDivisionPoints[player_position_short($key)] = $value;
        }

        return $this->calculatePlayerPoints($division, $teamId, $tempDivisionPoints);
    }

    public function calculatePlayerPoints($division, $teamId, $pointCalculation)
    {
        $positionOrder = $division->getPositionOrder();
        $month = $this->getMonthDate();
        $week = $this->getWeekDate();
        $playersSeasonPoints = $this->repository->getTeamPlayersPoints($teamId);

        $playersSeasonPoints->map(function ($item, $key) use ($teamId, $positionOrder, $month, $week, $pointCalculation, $division) {
            $pos = player_position_short($item->position);

            $monthPoints = $this->repository->getTeamPlayerScoreDatewise($teamId, $item->player_id, $month)->first();
            $monthPoint = $this->calculatePlayerPointsPackageWise($monthPoints, $pos, $pointCalculation, $item->player_id);

            $item->month_points = $monthPoint;

            $weekPoints = $this->repository->getTeamPlayerScoreDatewise($teamId, $item->player_id, $week)->first();
            $weekPoint = $this->calculatePlayerPointsPackageWise($weekPoints, $pos, $pointCalculation, $item->player_id);
            $item->week_points = $weekPoint;
            $item->positionOrder = isset($positionOrder[$pos]) ? $positionOrder[$pos] : 0;
            $item->playerPositionShort = $pos;
        });

        return $playersSeasonPoints->sortBy('positionOrder');
    }

    public function getMonthDate()
    {
        $data['startDate'] = now()->startOfMonth();
        $data['endDate'] = now()->endOfMonth();

        return $data;
    }

    public function getWeekDate()
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

        return $data;
    }

    public function calculatePlayerPointsPackageWise($point, $pos, $pointCalculation, $playerId)
    {
        $goal = isset($pointCalculation[$pos][EventsEnum::GOAL]) && $pointCalculation[$pos][EventsEnum::GOAL] ? $pointCalculation[$pos][EventsEnum::GOAL] : 0;

        $assist = isset($pointCalculation[$pos][EventsEnum::ASSIST]) && $pointCalculation[$pos][EventsEnum::ASSIST] ? $pointCalculation[$pos][EventsEnum::ASSIST] : 0;
        $goalConceded = isset($pointCalculation[$pos][EventsEnum::GOAL_CONCEDED]) && $pointCalculation[$pos][EventsEnum::GOAL_CONCEDED] ? $pointCalculation[$pos][EventsEnum::GOAL_CONCEDED] : 0;
        $cleanSheet = isset($pointCalculation[$pos][EventsEnum::CLEAN_SHEET]) && $pointCalculation[$pos][EventsEnum::CLEAN_SHEET] ? $pointCalculation[$pos][EventsEnum::CLEAN_SHEET] : 0;
        $appearance = isset($pointCalculation[$pos][EventsEnum::APPEARANCE]) && $pointCalculation[$pos][EventsEnum::APPEARANCE] ? $pointCalculation[$pos][EventsEnum::APPEARANCE] : 0;
        $clubWin = isset($pointCalculation[$pos][EventsEnum::CLUB_WIN]) && $pointCalculation[$pos][EventsEnum::CLUB_WIN] ? $pointCalculation[$pos][EventsEnum::CLUB_WIN] : 0;
        $redCard = isset($pointCalculation[$pos][EventsEnum::RED_CARD]) && $pointCalculation[$pos][EventsEnum::RED_CARD] ? $pointCalculation[$pos][EventsEnum::RED_CARD] : 0;
        $yellowCard = isset($pointCalculation[$pos][EventsEnum::YELLOW_CARD]) && $pointCalculation[$pos][EventsEnum::YELLOW_CARD] ? $pointCalculation[$pos][EventsEnum::YELLOW_CARD] : 0;
        $ownGoal = isset($pointCalculation[$pos][EventsEnum::OWN_GOAL]) && $pointCalculation[$pos][EventsEnum::OWN_GOAL] ? $pointCalculation[$pos][EventsEnum::OWN_GOAL] : 0;
        $penaltyMissed = isset($pointCalculation[$pos][EventsEnum::PENALTY_MISSED]) && $pointCalculation[$pos][EventsEnum::PENALTY_MISSED] ? $pointCalculation[$pos][EventsEnum::PENALTY_MISSED] : 0;
        $penaltySave = isset($pointCalculation[$pos][EventsEnum::PENALTY_SAVE]) && $pointCalculation[$pos][EventsEnum::PENALTY_SAVE] ? $pointCalculation[$pos][EventsEnum::PENALTY_SAVE] : 0;
        $goalkeeperSave = isset($pointCalculation[$pos][EventsEnum::GOALKEEPER_SAVE_X5]) && $pointCalculation[$pos][EventsEnum::GOALKEEPER_SAVE_X5] ? $pointCalculation[$pos][EventsEnum::GOALKEEPER_SAVE_X5] : 0;

        $total = 0;
        $total += $goal * $point->total_goal;
        $total += $assist * $point->total_assist;
        $total += $goalConceded * $point->total_conceded;
        $total += $cleanSheet * $point->total_clean_sheet;
        $total += $appearance * $point->total_appearance;
        $total += $clubWin * $point->total_club_win;
        $total += $yellowCard * $point->total_yellow_card;
        $total += $redCard * $point->total_red_card;
        $total += $ownGoal * $point->total_own_goal;
        $total += $penaltyMissed * $point->total_penalty_missed;
        $total += $penaltySave * $point->total_penalty_saved;
        $total += $goalkeeperSave * $point->total_goalkeeper_save;

        return $total;
    }

    public function leagStandingAcitveGameWeek($gameweeks)
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

    public function getRequestPendingTeams($consumer)
    {
        return $this->repository->getRequestPendingTeams($consumer);
    }
}
