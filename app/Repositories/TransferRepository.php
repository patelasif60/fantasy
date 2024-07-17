<?php

namespace App\Repositories;

use DB;
use App\Models\Team;
use App\Models\Fixture;
use App\Models\Player;
use App\Models\Season;
use App\Models\GameWeek;
use App\Models\Transfer;
use Illuminate\Support\Arr;
use App\Models\TeamPlayerPoint;
use App\Enums\CompetitionEnum;
use App\Enums\HistoryPeriodEnum;
use Illuminate\Support\Carbon;
use App\Models\TeamPlayerContract;
use App\Enums\HistoryTransferTypeEnum;
use App\Enums\PlayerContractPosition\AllPositionEnum;

class TransferRepository
{
    public function create($data)
    {
        // if($data['transfer_type'] == "swapdeal" || $data['transfer_type'] == "transfer" ||$data['transfer_type'] == "sealedbids")
        // {
        //     $transfer = Team::where('id', $data['team_id'])->first();
        //     $division = $transfer->teamDivision->first();
        //     $season_free_agent_transfer_limit = $division->getOptionValue('season_free_agent_transfer_limit');
        //     if (($transfer->season_quota_used + 1) > $season_free_agent_transfer_limit) {
        //         return false;
        //     }

        //     $monthly_free_agent_transfer_limit = $division->getOptionValue('monthly_free_agent_transfer_limit');
        //     if (($transfer->monthly_quota_used + 1) > $monthly_free_agent_transfer_limit) {
        //         return false;
        //     }

        //     $return = Transfer::create([
        //     'team_id' => $data['team_id'],
        //     'player_in' => Arr::get($data, 'player_in', null),
        //     'player_out' => Arr::get($data, 'player_out', null),
        //     'transfer_type' => $data['transfer_type'],
        //     'transfer_value' => $data['transfer_value'],
        //     'transfer_date' => $data['transfer_date'],
        //     ]);

        //     $teamPlayerRepository = app(TeamPlayerRepository::class);
        //     $teamPlayerRepository->addTransferQuata($data['team_id']);
        // }
        // else{
        $return = Transfer::create([
            'team_id' => $data['team_id'],
            'player_in' => Arr::get($data, 'player_in', null),
            'player_out' => Arr::get($data, 'player_out', null),
            'transfer_type' => $data['transfer_type'],
            'transfer_value' => $data['transfer_value'],
            'transfer_date' => $data['transfer_date'],
        ]);
        // }
        return $return;
    }

    public function update($transfer, $data)
    {
        $transfer->fill([
            'team_id' => $data['team_id'],
            'player_in' => Arr::get($data, 'player_in', null),
            'player_out' => Arr::get($data, 'player_out', null),
            'transfer_type' => $data['transfer_type'],
            'transfer_value' => $data['transfer_value'],
            'transfer_date' => $data['transfer_date'],
        ]);

        $transfer->save();

        return $transfer;
    }

    // public function divisionTransferHistory($division, $data)
    // {
    //     $transfer = Transfer::join('teams', 'teams.id', '=', 'transfers.team_id')
    //         ->join('division_teams', 'division_teams.team_id', '=', 'teams.id')

    //         ->leftJoin('players as players_in', 'players_in.id', '=', 'transfers.player_in')
    //         ->leftJoin('players as players_out', 'players_out.id', '=', 'transfers.player_out')

    //          ->leftJoin('player_contracts as player_contracts_in', function ($join) {
    //              $join->on('player_contracts_in.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players_in.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date))))'));
    //          })

    //          ->leftJoin('player_contracts as player_contracts_out', function ($join) {
    //              $join->on('player_contracts_out.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players_out.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date))))'));
    //          })

    //         // ->leftJoin('player_contracts as player_contracts_in', 'player_contracts_in.player_id', '=', 'transfers.player_in')
    //         // ->leftJoin('player_contracts as player_contracts_out', 'player_contracts_out.player_id', '=', 'transfers.player_out')

    //         ->leftJoin('clubs as player_in_club', 'player_in_club.id', '=', 'player_contracts_in.club_id')
    //         ->leftJoin('clubs as player_out_club', 'player_out_club.id', '=', 'player_contracts_out.club_id')
    //         ->leftJoin('consumers', 'consumers.id', '=', 'teams.manager_id')
    //         ->leftJoin('users', 'users.id', '=', 'consumers.user_id')
    //         ->selectRaw('transfers.transfer_date,transfers.transfer_value,teams.name,teams.id,transfers.transfer_type,players_in.first_name as player_in_first_name,players_in.last_name as player_in_last_name,players_out.first_name as player_out_first_name,players_out.last_name as player_out_last_name,users.first_name as user_first_name,users.last_name as user_last_name,players_in.short_code as player_in_short_code,players_out.short_code as player_out_short_code,player_in_club.short_code as player_in_club_name,player_out_club.short_code as player_out_club_name,player_contracts_in.position as player_in_position,player_contracts_out.position as player_out_position,IF(transfers.transfer_type = "budgetcorrection", IF(transfers.transfer_value > 0, transfers.transfer_value, "Notrequired"), transfers.transfer_value ) AS transfer_type_value')
    //         ->where('division_teams.division_id', $division->id)
    //         ->whereIn('transfers.transfer_type', collect(HistoryTransferTypeEnum::toArray())->values());

    //     if (Arr::has($data, 'type')) {
    //         $transfer = $transfer->where('transfers.transfer_type', $data['type']);
    //     }

    //     if (Arr::has($data, 'period')) {
    //         $endDate = Carbon::now()->format(config('fantasy.db.datetime.format'));

    //         if ($data['period'] == HistoryPeriodEnum::SEVEN_DAYS) {
    //             $startDate = Carbon::now()->subDays(7)->format(config('fantasy.db.datetime.format'));
    //         } elseif ($data['period'] == HistoryPeriodEnum::THIRTY_DAYS) {
    //             $startDate = Carbon::now()->subDays(30)->format(config('fantasy.db.datetime.format'));
    //         } elseif ($data['period'] == HistoryPeriodEnum::SEASON) {
    //             $latestSeason = Season::orderBy('id', 'desc')->first();
    //             $startDate = $latestSeason->start_at;
    //             $endDate = $latestSeason->end_at;
    //         }

    //         $transfer = $transfer->where('transfers.transfer_date', '>=', $startDate)->where('transfers.transfer_date', '<=', $endDate);
    //     }

    //     return $transfer->orderBy('transfers.transfer_date', 'desc')
    //             ->groupBy('transfers.id', 'teams.name', 'player_in_first_name', 'player_in_last_name', 'player_out_first_name', 'player_out_last_name', 'user_first_name', 'user_last_name', 'player_in_short_code', 'player_out_short_code', 'player_in_club_name', 'player_out_club_name', 'player_in_position', 'player_out_position')
    //             ->havingRaw('transfer_type_value != "Notrequired"')
    //             ->orHavingRaw('transfer_type_value IS NULL')
    //             ->get();
    // }

    public function getTeamTransferPlayers($team)
    {
        $division = $team->teamDivision->first();
        $auctionDate = carbon_get_date_from_date_time($division->auction_date);

        return Team::join('team_player_contracts', 'team_player_contracts.team_id', '=', 'teams.id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->leftjoin('transfers', function ($join) {
                $join->on('transfers.id', '=', DB::raw('(SELECT id FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in and transfers.transfer_type NOT IN ("substitution","supersub")  ORDER BY id DESC LIMIT 1)'));
            })

            // ->join('player_contracts as latest_player_contracts', function ($join) {
            //     $join->on('latest_player_contracts.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date)))Order By id desc limit 1)'));
            // })
            ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE id = ( SELECT IF ((SELECT transfer_type FROM transfers WHERE transfers.team_id = teams.id AND players.id = transfers.player_in AND transfers.transfer_type NOT IN ('substitution','supersub') ORDER BY id DESC LIMIT 1) = 'auction' AND '".$auctionDate."' = DATE(transfers.transfer_date), (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR (  player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."' ) ) ORDER BY id DESC LIMIT 1) , (SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date) ) ) ORDER BY id DESC LIMIT 1 )) AS id ))"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->selectRaw('teams.id as team_id,players.id as player_id,teams.name as team_name,transfers.transfer_value,players.first_name as player_first_name,players.last_name as player_last_name,clubs.short_code,player_contracts.position,clubs.name as club_name,clubs.id as club_id,transfers.transfer_value,team_player_contracts.is_active as subsAct')//,SUM(fixture_stats.goal) as total_points')
            ->where('teams.id', $team->id)
            ->whereNull('team_player_contracts.end_date')
            ->where('clubs.is_premier', true)
            ->groupBy('teams.id', 'players.id', 'clubs.short_code', 'clubs.id', 'player_contracts.position', 'clubs.name', 'transfers.transfer_value', 'team_player_contracts.is_active')
            ->get();
    }

    public function getPlayersStats($playerIds)
    {
        $players = Player::leftJoin('fixture_stats as fixture_stats_for_stats', function ($join) {
            $join->on('fixture_stats_for_stats.player_id', '=', 'players.id');
            $join->whereIn('fixture_stats_for_stats.fixture_id',
                    function ($query) {
                        $query->select('id')
                        ->from('fixtures')
                        ->where('competition', CompetitionEnum::PREMIER_LEAGUE)
                        ->where('season_id', Season::getLatestSeason());
                    });
        })->leftJoin('fixtures', function ($join) {
            $join->on('fixtures.id', '=', 'fixture_stats_for_stats.fixture_id');
        })->selectRaw('players.id as playerId,
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
                    SUM(fixture_stats_for_stats.club_win) as total_club_win')
                ->whereIn('players.id', $playerIds)
                ->groupBy('players.id')
                ->get();

        return $players;
    }

    public function getTransferPlayers($division, $team, $data)
    {
        $auctionDate = carbon_get_date_from_date_time(now());
        $teamIds = $division->divisionTeams->pluck('id');
        $playersId = TeamPlayerContract::whereIn('team_id', $teamIds)->whereNull('team_player_contracts.end_date')->pluck('player_id');

        $players = Player::join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                    $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."')) ORDER BY id desc LIMIT 1)"));
                })
                ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')

                ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                ->leftJoin(DB::raw('(team_player_contracts INNER JOIN teams ON teams.id = team_player_contracts.team_id and team_player_contracts.end_date is null INNER JOIN division_teams ON division_teams.team_id = teams.id AND division_teams.division_id = '.$division->id.')'),
                  function ($join) {
                      $join->on('team_player_contracts.player_id', '=', 'players.id');
                })
                ->selectRaw('players.id,
                    players.first_name as player_first_name,
                    players.last_name as player_last_name,
                    players.short_code as player_short_code,
                    clubs.id as club_id,
                    clubs.name as club_name,
                    clubs.short_code as shortCode,
                    player_contracts.position,
                    teams.id as team_id,
                    teams.name as team_name,
                    clubs.short_code,
                    team_player_contracts.id as team_player_contract_id')
                ->whereNull('player_contracts.end_date')
                ->where('player_contracts.is_active', true)
                ->where('clubs.is_premier', true)
                ->whereNotIn('players.id', $playersId);
        if (Arr::has($data, 'position') && Arr::get($data, 'position')) {
            if ($data['position'] == AllPositionEnum::DEFENDER) {
                $players = $players->where(function ($query) {
                    $query->orwhere('player_contracts.position', AllPositionEnum::CENTREBACK)
                                      ->orWhere('player_contracts.position', AllPositionEnum::FULLBACK);
                });
            } elseif ($data['position'] == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
                $players = $players->where('player_contracts.position', AllPositionEnum::DEFENSIVE_MIDFIELDER);
            } elseif ($data['position'] == AllPositionEnum::MIDFIELDER) {
                if ($division->getOptionValue('defensive_midfields') != 'Yes') {
                    $players = $players->where(function ($query) {
                        $query->orwhere('player_contracts.position', AllPositionEnum::DEFENSIVE_MIDFIELDER)
                                      ->orWhere('player_contracts.position', AllPositionEnum::MIDFIELDER);
                    });
                } else {
                    $players = $players->where('player_contracts.position', AllPositionEnum::MIDFIELDER);
                }
            } else {
                $players = $players->where('player_contracts.position', $data['position']);
            }
        }
        if (Arr::has($data, 'club') && Arr::get($data, 'club')) {
            $players = $players->where('clubs.id', array_get($data, 'club'));
        }
        if (Arr::has($data, 'player') && Arr::get($data, 'player')) {
            $players = $players->where(function ($query) use ($data) {
                $query->where('players.first_name', 'like', '%'.escape_like(array_get($data, 'player')).'%')
                                    ->orWhere('players.last_name', 'like', '%'.escape_like(array_get($data, 'player')).'%')
                                    ->orWhere('clubs.short_code', 'like', '%'.escape_like(array_get($data, 'player')).'%')
                                    ->orWhere('players.short_code', 'like', '%'.escape_like(array_get($data, 'player')).'%');
            });
        }
        
        if (Arr::has($data, 'boughtPlayers') && Arr::get($data, 'boughtPlayers') == 'yes') {
            $players = $players->whereNull('team_player_contracts.id');
        }

        return $players->groupBy('players.id', 'clubs.id', 'clubs.name', 'player_contracts.position', 'teams.id', 'teams.name', 'clubs.short_code', 'team_player_contracts.id')
                ->orderBy('players.first_name')
                ->get();
    }

    public function getNextFixture($club)
    {
        $nextFixture = Fixture::where(function ($query) use ($club) {
            $query->where('home_club_id', $club)
                                    ->orWhere('away_club_id', $club);
        })
                            ->where('date_time', '>', date('Y-m-d'))
                            ->orderBy('date_time')
                            ->first();

        return $nextFixture;
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

    public function getTeamClubsPlayer($team)
    {
        return TeamPlayerContract::join('player_contracts', 'player_contracts.player_id', '=', 'team_player_contracts.player_id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->where('team_player_contracts.team_id', $team->id)
            ->whereNull('player_contracts.end_date')
            ->whereNull('team_player_contracts.end_date')
            ->selectRaw('count(clubs.id) as total,clubs.id as club_id')
            ->groupBy('clubs.id')
            ->pluck('total', 'club_id');
    }

    public function getTeamPlayerPostions($team, $totalPlayers)
    {
        $division = $team->teamDivision->first();

        $auctionDate = carbon_get_date_from_date_time(now());
        // return TeamPlayerContract::join('players', 'players.id', '=', 'team_player_contracts.player_id')
        return player::join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
            $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR (player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."')) limit 1)"));
        })

            //->join('player_contracts', 'player_contracts.player_id', '=', 'team_player_contracts.player_id')
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            //->where('team_player_contracts.team_id', $team->id)
            //->whereNull('player_contracts.end_date')
            //->whereNull('team_player_contracts.end_date')
            ->whereIn('players.id', $totalPlayers)
            ->selectRaw('count(player_contracts.position) as total,player_contracts.position')
            ->groupBy('player_contracts.position')
            ->get();
    }

    public function playerWeekPoints($player_id)
    {
        $date = \Carbon\Carbon::now()->format('Y-m-d');
        $gameweeks = GameWeek::where('start', '<=', $date)->where('season_id', Season::getLatestSeason());
        if ($gameweeks) {
            $gameweeks = $gameweeks->limit(1);
        }
        $gameweek = $gameweeks->orderBy('start', 'desc')->first();

        $playerStats = TeamPlayerPoint::join('team_points', 'team_points.id', '=', 'team_player_points.team_point_id')
                        ->join('fixtures', function ($query) use ($gameweek) {
                            $query->on('fixtures.id', '=', 'team_points.fixture_id')
                                ->whereBetween('fixtures.date_time', [$gameweek->start, $gameweek->end])
                                ->where('season_id', Season::getLatestSeason());
                        })
                        ->selectRaw('
                            team_player_points.player_id,
                            SUM(team_player_points.total) as total
                        ')
                        ->where('team_player_points.player_id', $player_id)
                        ->groupBy('team_player_points.player_id')
                        ->get();

        if (isset($playerStats[0])) {
            return $playerStats[0]->total;
        } else {
            return 0;
        }
    }

    public function getActiveTeamPlayerPostions($team)
    {
        $division = $team->teamDivision()->first();

        $auctionDate = carbon_get_date_from_date_time(now());

        return TeamPlayerContract::join('players', 'players.id', '=', 'team_player_contracts.player_id')
         ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
             $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."')) LIMIT 1)"));
         })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->where('team_player_contracts.team_id', $team->id)
            ->whereNull('player_contracts.end_date')
            ->whereNull('team_player_contracts.end_date')
            ->where('team_player_contracts.is_active', '=', 1)
            ->selectRaw('count(player_contracts.position) as total,player_contracts.position')
            ->groupBy('player_contracts.position')
            ->get();
    }

    public function getActiveTeamPlayerPositionReport($team)
    {
        $auctionDate = carbon_get_date_from_date_time(now());

        return TeamPlayerContract::join('players', 'players.id', '=', 'team_player_contracts.player_id')
             ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                 $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR (player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."')) LIMIT 1)"));
             })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->where('team_player_contracts.team_id', $team->id)
            ->whereNull('player_contracts.end_date')
            ->whereNull('team_player_contracts.end_date')
            ->where('team_player_contracts.is_active', '=', 1)
            ->selectRaw('count(player_contracts.position) as total,player_contracts.position')
            ->groupBy('player_contracts.position')
            ->get();
    }

    public function getTeamPlayerContracts($team)
    {
        $division = $team->teamDivision->first();

        $auctionDate = carbon_get_date_from_date_time(now());

        return TeamPlayerContract::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR (  player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."')))"));
            })
            ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
             ->select('teams.id as team_id', 'players.id as player_id', 'teams.name as team_name', 'players.first_name as player_first_name', 'players.last_name as player_last_name', 'clubs.short_code', 'player_contracts.position', 'clubs.name as club_name', 'team_player_contracts.id')
            ->where('teams.id', $team->id)
            ->whereNull('team_player_contracts.end_date')->get();
    }

    public function getTransferPlayerOtherTeamCount($division, $transferPlayersArray)
    {
        $teamIds = $division->divisionTeams->pluck('id');

        return TeamPlayerContract::whereIn('team_id', $teamIds)
        ->whereNull('team_player_contracts.end_date')
        ->whereIn('team_player_contracts.player_id', $transferPlayersArray)
        ->count();
    }

    public function getTransferPlayerInTeamCount($team, $transferPlayersArray)
    {
        $count = TeamPlayerContract::where('team_id', $team->id)
                ->whereNull('team_player_contracts.end_date')
                ->whereIn('team_player_contracts.player_id', $transferPlayersArray)
                ->count();

        return count($transferPlayersArray) == $count ? true : false;
    }

    public function getPlayersForTransfers($boughtPlayerIds)
    {
        $auctionDate = carbon_get_date_from_date_time(now());

        $players = Player::join('player_contracts as latest_player_contracts', function ($join) use ($auctionDate) {
                    $join->on('latest_player_contracts.id', '=', DB::raw("(SELECT id FROM player_contracts WHERE player_contracts.player_id = players.id AND( ( ( '".$auctionDate."' >= player_contracts.start_date AND '".$auctionDate."' <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= '".$auctionDate."'))Order By id desc limit 1)"));
                })
                ->join('player_contracts', 'player_contracts.id', '=', 'latest_player_contracts.id')
                ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                ->selectRaw('players.id,clubs.id as club_id')
                ->whereNull('player_contracts.end_date')
                ->where('player_contracts.is_active', true)
                ->where('clubs.is_premier', true)
                ->whereIn('players.id', $boughtPlayerIds)
                ->groupBy('players.id', 'clubs.id')
                ->get();

        return $players;
    }
}
