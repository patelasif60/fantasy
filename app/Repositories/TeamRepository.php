<?php

namespace App\Repositories;

use App\Enums\CompetitionEnum;
use App\Enums\TransferTypeEnum;
use App\Enums\YesNoEnum;
use App\Models\Consumer;
use App\Models\Division;
use App\Models\DivisionPaymentDetail;
use App\Models\DivisionTeam;
use App\Models\Fixture;
use App\Models\GameWeek;
use App\Models\Pitch;
use App\Models\PredefinedCrest;
use App\Models\Season;
use App\Models\Team;
use App\Models\TeamPlayerContract;
use App\Models\TeamPoint;
use App\Models\Transfer;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TeamRepository
{
    const LINE_UP = 'lineup';
    const BENCH = 'bench';

    public function create($data)
    {
        $division = Division::find($data['division_id']);
        $team_budget = $division->getOptionValue('pre_season_auction_budget');
        $isFreeCount = DivisionTeam::where('division_id', $data['division_id'])->where('is_free', 1)->count();
        $team = Team::create([
            'name' => $data['name'],
            'manager_id' => $data['manager_id'],
            'pitch_id' => Arr::has($data, 'pitch_id') ? $data['pitch_id'] : 0,
            'crest_id' => Arr::get($data, 'crest_id', null),
            'pitch_id' => Arr::get($data, 'pitch_id', null),
            'is_approved' => Arr::has($data, 'is_approved') ? $data['is_approved'] : 1,
            'team_budget' => $team_budget,
            'uuid' => (string) Str::uuid(),
        ]);

        $checkNewUserteam = false;
        if($division->package->free_placce_for_new_user == 'Yes') {
            $checkNewUserteam = $this->checkNewUserteam($data['manager_id']) && $this->checkNewUserteamPrevious($data['manager_id']);
            if ($checkNewUserteam) {
                $divisionUid = Division::where('uuid', $division->uuid)->count();
                if ($divisionUid > 1 || $division->is_legacy == 1) {
                    if ($division->package->free_placce_for_new_user == YesNoEnum::NO) {
                        if ($isFreeCount >= $data['max_free_places']) {
                            $checkNewUserteam = false;
                        }
                    } else {
                        $checkNewUserteam = false;
                    }
                } else {
                    if ($division->package->free_placce_for_new_user == YesNoEnum::YES) {
                        if ($isFreeCount >= $data['max_free_places']) {
                            $checkNewUserteam = false;
                        }
                    } else {
                        $checkNewUserteam = false;
                    }
                }
            }
        }
        
        $team->teamDivision()->attach($division->id, ['season_id' => Season::getLatestSeason(), 'is_free'=> $checkNewUserteam]);

        return $team;
    }

    public function update($team, $data)
    {
        $teamDivision = $team->teamDivision->first();

        $team->fill([
            'name' => $data['name'],
            'manager_id' => $data['manager_id'],
            'crest_id' => Arr::get($data, 'crest_id', null),
            'pitch_id' => Arr::get($data, 'pitch_id', null),
            'season_quota_used' => Arr::get($data, 'season_quota_used') ? $teamDivision->getOptionValue('season_free_agent_transfer_limit') - Arr::get($data, 'season_quota_used') : $team->season_quota_used,
            'monthly_quota_used' => Arr::get($data, 'monthly_quota_used') ? $teamDivision->getOptionValue('monthly_free_agent_transfer_limit') - Arr::get($data, 'monthly_quota_used') : $team->monthly_quota_used,
        ]);
        
        $team->save();

        if (isset($data['division_id'])) {

            $divisionTeam = DivisionTeam::where('team_id', $team->id)->where('season_id', Season::getLatestSeason())->first();
            $divisionTeam->update(['division_id' => $data['division_id']]);
        }

        return $team;
    }

    public function validateTeamName($team_name)
    {
        $filter = app('profanityFilter')->filter($team_name);

        return ($filter !== $team_name) ? 'false' : 'true';
    }

    public function getDivisions($season)
    {
        return Division::join('division_teams', 'divisions.id', '=', 'division_teams.division_id')
            ->where('division_teams.season_id', $season)
            ->orderBy('divisions.name')
            ->pluck('divisions.name', 'divisions.id')
            ->all();

        // return Division::orderBy('name')->pluck('name', 'id')->all();
    }

    public function getConsumers()
    {
        return Consumer::join('users', 'users.id', '=', 'consumers.user_id')
            ->select('consumers.id', 'users.first_name', 'users.last_name', 'users.email')
            ->orderBy('users.first_name')
            ->get();
    }

    public function getManager($team)
    {
        return Consumer::join('users', 'users.id', '=', 'consumers.user_id')
            ->select('consumers.id', 'users.first_name', 'users.last_name', 'users.email')
            ->where('consumers.id', $team->manager_id)
            ->get();
    }

    public function getPredefinedCrests()
    {
        return PredefinedCrest::IsPublished()->get();
    }

    public function getTeamSeasons()
    {
        return Season::whereIn('id', DivisionTeam::groupBy('season_id')->pluck('season_id'))->orderBy('id', 'desc')->pluck('name', 'id')->all();
    }

    public function getPitches()
    {
        return Pitch::orderBy('name')->IsPublished()->pluck('name', 'id')->all();
    }

    public function updateCrest($team, $data)
    {
        $team->fill([
            'crest_id' => Arr::get($data, 'crest_id', null),
        ]);
        $team->save();

        return $team;
    }

    public function updatePitch($team, $data)
    {
        $team->fill([
            'pitch_id' => Arr::get($data, 'pitch_id', null),
        ]);
        $team->save();

        return $team;
    }

    public function crestDestroy($team)
    {
        return $team->clearMediaCollection('crest');
    }

    public function updateTeamName($team, $data)
    {
        $team->fill([
            'name' => $data['team_name'],
        ]);
        $team->save();

        return $team;
    }

    public function getTeam($team)
    {
        return Team::find($team);
    }

    public function approveTeam($team)
    {
        $team->fill([
            'is_approved' => true,
        ]);
        $team->save();

        return $team;
    }

    public function ignoreTeam($team)
    {   
        $team->fill([
            'is_ignored' => true,
        ]);
        $team->save();

        return $team;
    }

    public function getDivisionPendingTeams($division)
    {
        return $division->divisionTeams()
                        ->with('consumer.user')
                        ->where(['is_approved'=> false , 'is_ignored'=> false ])
                        ->get();
    }

    public function getTeamForCustomCup($division)
    {
        $teams = Team::join('division_teams', 'division_teams.team_id', '=', 'teams.id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->where('division_teams.season_id', Season::getLatestSeason())
            ->where('teams.is_approved', true);

        if ($division->parentDivision) {
            $teams = $teams->whereIn('divisions.id', [$division->id, $division->parentDivision->id]);
        } else {
            $teams = $teams->where('divisions.id', $division->id);
        }

        $teams = $teams->select('teams.*', 'users.first_name', 'users.last_name')->get();

        return $teams;
    }

    public function getTeamStats4Lineup($team, $division)
    {
        $team_stats = [];

        if (! isset($division->id)) {
            $team_stats['current_week'] = $team_stats['week_total'] = $team_stats['facup_prev'] = $team_stats['facup_total'] = 0;

            return $team_stats;
        }

        $conditions = ['date_interval' => true, 'competition' => 'Premier League'];
        $team_stats['current_week'] = $this->getTeamStats($team, $division, $conditions);

        $conditions = ['date_interval' => false, 'competition' => 'Premier League'];
        $team_stats['week_total'] = $this->getTeamStats($team, $division, $conditions);

        $today = Carbon::now()->format('Y-m-d');

        $prevRound = Fixture::where('competition', 'FA Cup')
                            ->where('season_id', Season::getLatestSeason())
                            ->where(DB::raw('CONVERT(fixtures.date_time, DATE)'), '<=', $today)
                            ->select('stage')
                            ->orderBy('id', 'desc')
                            ->first();
        // ->skip(1)->first();

        // $prevRound = Fixture::where('competition', 'FA Cup')
        //                     ->where(function ($query) use ($division) {
        //                         $query->where('home_club_id', $division->id)
        //                             ->orWhere('away_club_id', $division->id);
        //                     })
        //                     ->where('season_id', Season::getLatestSeason())
        //                     ->select('stage')
        //                     ->orderBy('date_time', 'desc')
        //                     ->skip(1)->first();

        $team_stats['facup_prev'] = 0;
        if (! empty($prevRound)) {
            $conditions = ['date_interval' => false, 'competition' => 'FA Cup', 'stage' => $prevRound->stage];
            $team_stats['facup_prev'] = $this->getTeamStats($team, $division, $conditions);
        }

        $conditions = ['date_interval' => false, 'competition' => 'FA Cup'];
        $team_stats['facup_total'] = $this->getTeamStats($team, $division, $conditions);

        return $team_stats;
    }

    public function getTeamStats($team, $division, $conditions)
    {
        $gameweek = '';
        if ($conditions['date_interval']) {
            $date = Carbon::now()->format('Y-m-d');

            $gameweek = GameWeek::where('season_id', Season::getLatestSeason())
                        ->where('start', '<=', now())
                        ->where('end', '>', now())
                        ->first();

            // $gameweeks = GameWeek::where('start', '<', $date)->where('season_id', Season::getLatestSeason());
            // if ($gameweeks) {
            //     $gameweeks = $gameweeks->limit(1);
            // }
            // $gameweek = $gameweeks->orderBy('start', 'desc')->first();

            // $activeGameWeek = GameWeek::where('season_id', Season::getLatestSeason())
            //                 ->where('start', '<=', now())
            //                 ->where('end', '>', now())
            //                 ->first();

            // $gameweek = GameWeek::find($activeGameWeek->id - 1);
        }

        if(is_null($gameweek)) {
            return 0;
        }

        $result = TeamPoint::join('fixtures', function ($query) use ($gameweek, $division, $conditions) {
            $query->on('fixtures.id', '=', 'team_points.fixture_id');
            if ($conditions['date_interval']) {
                $query->whereBetween('fixtures.date_time', [$gameweek->start, $gameweek->end]);
            }
            if (isset($conditions['stage'])) {
                $query->where('fixtures.stage', $conditions['stage']);
            }
            $query->where('fixtures.competition', $conditions['competition']);
            $query->where('fixtures.season_id', Season::getLatestSeason());
        })
                        ->where('team_points.team_id', $team->id)
                        ->select(DB::raw('SUM(team_points.total) as total'))
                        ->orderBy('team_points.team_id')
                        ->first();
        $result = $result->total ? $result->total : 0;

        return $result;
    }

    public function getLatestTeamCrests()
    {
        return Team::whereDate('created_at', Carbon::today())
        ->whereNull('crest_id')
        ->with(['consumer', 'teamDivision'])
        ->get();
    }

    public function delete(Team $team)
    {
        return Team::find($team->id)->delete();
    }

    public function checkNewUserteam($managerId)
    {
        $teams = Team::JOIN('division_teams', 'division_teams.team_id', '=', 'teams.id')
            ->where('division_teams.season_id', Season::getPreviousSeason())
            ->where('teams.manager_id', $managerId)
            ->count('division_teams.id');
        if ($teams > 0) {
            return false;
        }

        return true;
    }

    public function checkNewUserteamPrevious($managerId)
    {
        $teams = Team::JOIN('division_teams', 'division_teams.team_id', '=', 'teams.id')
        ->where('division_teams.season_id', Season::getLatestSeason())
        ->where('teams.manager_id', $managerId)
        ->where('teams.is_legacy', 1)
        ->count('division_teams.id');
        if ($teams > 0) {
            return false;
        }

        return true;
    }

    public function markAsUnPaid(Team $team)
    {
        return $team->teamDivision[0]->pivot->fill(['payment_id' => null])->save();
    }

    public function markAsPaid(Team $team)
    {
        $division = $team->teamDivision[0];

        $divisionPaymentDetail = DivisionPaymentDetail::create([
            'manager_id' => $team->manager_id,
            'division_id' => $division->id,
            'amount' => null,
            'status' => 'SUCCESS',
            'token' => 'By admin mark as paid',
            'worldpay_ordercode' => 'By admin mark as paid',
        ]);

        return $division->pivot->fill(['payment_id' => $divisionPaymentDetail->id])->save();
    }

    public function getDivisionTeamsDetails($division)
    {
        return Team::with('transferBudget')
                    ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
                    ->join('users', 'users.id', '=', 'consumers.user_id')
                    ->whereIn('teams.id', $division->divisionTeams->pluck('id'))
                    ->approve()
                    ->select('teams.*', 'users.first_name', 'users.last_name')
                    ->get();
    }

    public function teamsBudgetUpdate($division, $teams)
    {
        $date = now()->format(config('fantasy.db.datetime.format'));
        foreach ($teams['budget_correction'] as $key => $value) {
            $team = Team::find($key);
            if ($team->team_budget != $value) {
                $budgetCorrectionValue = $value - $team->team_budget;
                $transfer = Transfer::create([
                    'team_id' => $key,
                    'player_in' => null,
                    'player_out' => null,
                    'transfer_type' => TransferTypeEnum::BUDGETCORRECTION,
                    'transfer_value' => $budgetCorrectionValue,
                    'transfer_date' => $date,
                ]);

                $team->fill([
                    'team_budget' => $team->team_budget + $budgetCorrectionValue,
                ])->save();
            }

            $team->fill([
                'season_quota_used' => $division->getOptionValue('season_free_agent_transfer_limit') - $teams['season_quota_used'][$key],
                'monthly_quota_used' => $division->getOptionValue('monthly_free_agent_transfer_limit') - $teams['monthly_quota_used'][$key],
            ])->save();
        }

        return $division;
    }

    public function playerData($division, $team, $status, $leagueType)
    {
        $season = Season::getLatestSeason();
        $auctionDate = carbon_get_date_from_date_time($division->auction_date);

        $query = TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')

            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })
            ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE id = ( SELECT IF ((SELECT transfer_type FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in AND transfers.transfer_type NOT IN ('substitution','supersub') ORDER BY id DESC LIMIT 1) = 'auction', (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."' ) ) ORDER BY id DESC LIMIT 1) , (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date) ) ) ORDER BY id DESC LIMIT 1 )) AS id ))"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->leftJoin('fixture_stats', function ($join) use ($season, $leagueType) {
                $join->on('fixture_stats.player_id', '=', 'team_player_contracts.player_id');
                $join->whereIn('fixture_stats.fixture_id', function ($query) use ($season, $leagueType) {
                    $query->select('id')
                              ->from('fixtures')
                              ->where('fixtures.competition', $leagueType)
                              ->whereRaw("((team_player_contracts.start_date <= fixtures.date_time AND team_player_contracts.end_date > fixtures.date_time) or (team_player_contracts.start_date <= fixtures.date_time AND team_player_contracts.end_date is null)) and fixtures.season_id = $season");
                });
            })
            ->selectRaw('
                SUM(IF(fixture_stats.appearance >= 45 , 1, 0)) AS played,
                COALESCE(SUM(fixture_stats.goal),0) AS goals,
                COALESCE(SUM(fixture_stats.assist),0) AS assists,
                COALESCE(SUM(fixture_stats.clean_sheet),0) AS clean_sheets,
                COALESCE(SUM(fixture_stats.goal_conceded),0) AS goal_against,
                COALESCE(SUM(fixture_stats.own_goal),0) as own_goal,
                COALESCE(SUM(fixture_stats.red_card),0) as red_card,
                COALESCE(SUM(fixture_stats.yellow_card),0) as yellow_card,
                COALESCE(SUM(fixture_stats.penalty_missed),0) as penalty_missed,
                COALESCE(SUM(fixture_stats.penalty_save),0) as penalty_saved,
                COALESCE(SUM(fixture_stats.goalkeeper_save DIV 5),0) as goalkeeper_save,
                COALESCE(SUM(fixture_stats.club_win),0) as club_win,
                team_player_contracts.player_id as id,
                players.first_name AS player_first_name,
                players.last_name AS player_last_name,
                player_contracts.position,
                clubs.name AS club_name,
                clubs.short_code,
                transfers.transfer_value
                ')

            ->where('clubs.is_premier', true)
            ->where('team_player_contracts.team_id', $team->id)
            ->orderBy('players.first_name');

        if ($status === self::LINE_UP) {
            $result = $query->where('team_player_contracts.is_active', true);
        }
        if ($status === self::BENCH) {
            $result = $query->where('team_player_contracts.is_active', false);
        }

        return $result->groupBy('player_contracts.position', 'players.first_name', 'players.last_name', 'clubs.name', 'clubs.short_code', 'transfers.id', 'team_player_contracts.player_id')
        ->get();
    }

    public function soldPlayers($division, $team, $leagueType)
    {
        $season = Season::getLatestSeason();

        $auctionDate = carbon_get_date_from_date_time($division->auction_date);
        $playerIds = TeamPlayerContract::where('team_id', $team->id)
                    ->whereNull('end_date')
                    ->groupBy('player_id')
                    ->pluck('player_id');

        return TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')

            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })
            ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE id = ( SELECT IF ((SELECT transfer_type FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in AND transfers.transfer_type NOT IN ('substitution','supersub') ORDER BY id DESC LIMIT 1) = 'auction', (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."' ) ) ORDER BY id DESC LIMIT 1) , (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date) ) ) ORDER BY id DESC LIMIT 1 )) AS id ))"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->leftJoin('fixture_stats', function ($join) use ($season, $leagueType) {
                $join->on('fixture_stats.player_id', '=', 'team_player_contracts.player_id');
                $join->whereIn('fixture_stats.fixture_id', function ($query) use ($season, $leagueType) {
                    $query->select('id')
                              ->from('fixtures')
                              ->where('fixtures.competition', $leagueType)
                              ->whereRaw("((team_player_contracts.start_date <= fixtures.date_time AND team_player_contracts.is_active = 1 AND team_player_contracts.end_date > fixtures.date_time) or (team_player_contracts.start_date <= fixtures.date_time AND team_player_contracts.end_date is null)) and fixtures.season_id = $season");
                });
            })
            ->selectRaw('team_player_contracts.player_id as id,players.first_name AS player_first_name,players.last_name AS player_last_name,
                player_contracts.position,
                clubs.name AS club_name,
                clubs.short_code,
                transfers.transfer_value,
                COALESCE(SUM(fixture_stats.goal),0) as goals,
                COALESCE(SUM(fixture_stats.assist),0) as assists,
                COALESCE(SUM(fixture_stats.goal_conceded),0) as goal_against,
                COALESCE(SUM(fixture_stats.clean_sheet),0) as clean_sheets,
                SUM(IF(fixture_stats.appearance >= 45 , 1, 0)) as played,
                COALESCE(SUM(fixture_stats.own_goal),0) as own_goal,
                COALESCE(SUM(fixture_stats.red_card),0) as red_card,
                COALESCE(SUM(fixture_stats.yellow_card),0) as yellow_card,
                COALESCE(SUM(fixture_stats.penalty_missed),0) as penalty_missed,
                COALESCE(SUM(fixture_stats.penalty_save),0) as penalty_saved,
                COALESCE(SUM(fixture_stats.goalkeeper_save DIV 5),0) as goalkeeper_save,
                COALESCE(SUM(fixture_stats.club_win),0) as club_win')

            ->where('clubs.is_premier', true)
            ->where('team_player_contracts.team_id', $team->id)
            ->whereNotIn('team_player_contracts.player_id', $playerIds)
            ->orderBy('players.first_name')
            ->groupBy('player_contracts.position', 'players.first_name', 'players.last_name', 'clubs.name', 'clubs.short_code', 'transfers.id', 'team_player_contracts.player_id')
            ->get();
    }

    public function getTeamPlayerContract($teamId)
    {
        return Team::join('team_player_contracts', 'team_player_contracts.team_id', '=', 'teams.id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('player_contracts', 'player_contracts.id', '=', 'team_player_contracts.player_id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
             ->selectRaw('teams.id as team_id,players.id as player_id,players.first_name,players.last_name,clubs.short_code,player_contracts.position,clubs.name as club_name,team_player_contracts.is_active')
            ->whereNull('team_player_contracts.end_date')
            ->where('clubs.is_premier', true)
            ->where('teams.id', $teamId)
            ->get();
    }

    public function getTeamPlayersPoints($teamId, $data = null)
    {
        $team = Team::find($teamId);
        $division = $team->teamDivision->first();
        $season = Season::getLatestSeason();

        $auctionDate = carbon_get_date_from_date_time($division->auction_date);

        return TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')

            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })
            ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE id = ( SELECT IF ((SELECT transfer_type FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in AND transfers.transfer_type NOT IN ('substitution','supersub') ORDER BY id DESC LIMIT 1) = 'auction', (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."' ) ) ORDER BY id DESC LIMIT 1) , (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date) ) ) ORDER BY id DESC LIMIT 1 )) AS id ))"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->leftJoin('fixture_stats as fixture_stats_for_stats', function ($join) use ($season, $data) {
                $join->on('fixture_stats_for_stats.player_id', '=', 'players.id');
                $join->whereIn('fixture_stats_for_stats.fixture_id',
                        function ($query) use ($season, $data) {
                            $query->select('id')
                            ->from('fixtures')
                            ->where('fixtures.competition', CompetitionEnum::PREMIER_LEAGUE)
                            ->where('season_id', $season);
                            if (Arr::get($data, 'startDate', 0)) {
                                $query->whereDate('fixtures.date_time', '>=', $data['startDate']);
                            }
                            if (Arr::get($data, 'endDate', 0)) {
                                $query->whereDate('fixtures.date_time', '<', $data['endDate']);
                            }
                        });
            })
            ->selectRaw('
                (SELECT SUM(total) FROM team_player_point_defaults WHERE team_id = teams.id AND player_id  = players.id)AS total_season_points_default,
                (SELECT SUM(total) FROM team_player_points WHERE team_id = teams.id AND player_id  = players.id)AS total_season_points,
                SUM(IF(fixture_stats_for_stats.appearance >= 45 , 1, 0)) AS played,
               SUM(fixture_stats_for_stats.goal) as total_goal,
                    SUM(fixture_stats_for_stats.assist) as total_assist,
                    SUM(fixture_stats_for_stats.goal_conceded) as total_goal_against,
                    SUM(fixture_stats_for_stats.clean_sheet) as total_clean_sheet,
                    SUM(IF(fixture_stats_for_stats.appearance >= 45 , 1, 0)) as total_game_played,
                    SUM(fixture_stats_for_stats.own_goal) as total_own_goal,
                    SUM(fixture_stats_for_stats.red_card) as total_red_card,
                    SUM(fixture_stats_for_stats.yellow_card) as total_yellow_card,
                    SUM(fixture_stats_for_stats.penalty_missed) as total_penalty_missed,
                    SUM(fixture_stats_for_stats.penalty_save) as total_penalty_saved,
                    SUM(fixture_stats_for_stats.goalkeeper_save DIV 5) as total_goalkeeper_save,
                    SUM(fixture_stats_for_stats.club_win) as total_club_win,
                    teams.id as team_id,
                    players.id as player_id,
                    players.first_name,
                    players.last_name,
                    clubs.short_code,
                    player_contracts.position,
                    clubs.name AS club_name,
                    clubs.short_code,
                    team_player_contracts.is_active
                ')

            ->where('clubs.is_premier', true)
            ->where('team_player_contracts.team_id', $teamId)
            ->whereNull('team_player_contracts.end_date')
            ->orderBy('players.last_name')
            ->groupBy('player_contracts.position', 'players.first_name', 'players.last_name', 'clubs.name', 'clubs.short_code', 'transfers.id', 'team_player_contracts.is_active', 'teams.id', 'players.id')
            ->get();
    }

    public function getTeamPlayerScoreDatewise($teamId, $playerId, $data)
    {
        return TeamPoint::join('fixtures', 'fixtures.id', '=', 'team_points.fixture_id')
                        ->join('team_player_points', 'team_player_points.team_point_id', '=', 'team_points.id')
                        ->selectRaw('
                            SUM(team_player_points.goal) as total_goal,
                            SUM(team_player_points.assist) as total_assist,
                            SUM(team_player_points.clean_sheet) as total_clean_sheet,
                            SUM(team_player_points.conceded) as total_conceded,
                            SUM(team_player_points.appearance) as total_appearance,
                            SUM(team_player_points.own_goal) as total_own_goal,
                            SUM(team_player_points.red_card) as total_red_card,
                            SUM(team_player_points.yellow_card) as total_yellow_card,
                            SUM(team_player_points.penalty_missed) as total_penalty_missed,
                            SUM(team_player_points.penalty_saved) as total_penalty_saved,
                            SUM(team_player_points.goalkeeper_save) as total_goalkeeper_save,
                            SUM(team_player_points.club_win) as total_club_win,
                            SUM(team_player_points.total) as total_point
                        ')
                        ->where('team_points.team_id', $teamId)
                        ->where('team_player_points.player_id', $playerId)
                        ->whereDate('fixtures.date_time', '>=', $data['startDate'])
                        ->whereDate('fixtures.date_time', '<=', $data['endDate'])
                        ->get();
    }

    public function getRequestPendingTeams($consumer)
    {
        $teams = Team::leftJoin('division_teams', function ($join) {
            $join->on('teams.id', '=', 'division_teams.team_id')
                ->where('division_teams.season_id', Season::getLatestSeason());
        })->where('teams.manager_id', $consumer->id)
        ->where('teams.is_approved', false)
        ->where('teams.is_ignored', false)
        ->select('teams.*')
        ->get();

        return $teams;
    }
}
