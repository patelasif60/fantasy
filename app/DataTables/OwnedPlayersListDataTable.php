<?php

namespace App\DataTables;

use App\Enums\CompetitionEnum;
use App\Enums\EventsEnum;
use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Enums\PositionsEnum;
use App\Models\Player;
use App\Models\Season;
use App\Models\TeamPlayerContract;
use App\Services\DivisionService;
use DB;
use Yajra\DataTables\Services\DataTable;

class OwnedPlayersListDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $division = request('division');
        $playerPositions = PositionsEnum::toSelectArray();
        $divisionService = app(DivisionService::class);
        $divisionPoints = $divisionService->getDivisionPoints($division, $playerPositions);
        $positionOrder = $division->getPositionOrder();

        return datatables($query)
        ->editColumn('position', function ($data) use ($divisionPoints, $division) {
            $position = $division->getPositionShortCode(player_position_short($data->position));

            return '<div class="player-wrapper js-player-details cursor-pointer" data-id="'.$data->id.'" data-name="'.$data->player_first_name.' '.$data->player_last_name.'" data-club="'.$data->club_name.'"><div><span class="custom-badge custom-badge-lg is-square is-'.strtolower($position).'">'.$position.'</span></div><div><div>'.get_player_name('firstNameFirstCharAndFullLastName', $data->player_first_name, $data->player_last_name).'</div></div>';
        })
        ->editColumn('total_goal', function ($data) use ($divisionPoints) {
            $goal = isset($divisionPoints[$data->position][EventsEnum::GOAL]) && $divisionPoints[$data->position][EventsEnum::GOAL] ? $divisionPoints[$data->position][EventsEnum::GOAL] : 0;

            return $goal === 0 ? 0 : $data->total_goal;
        })
        ->editColumn('total_assist', function ($data) use ($divisionPoints) {
            $assist = isset($divisionPoints[$data->position][EventsEnum::ASSIST]) && $divisionPoints[$data->position][EventsEnum::ASSIST] ? $divisionPoints[$data->position][EventsEnum::ASSIST] : 0;

            return $assist === 0 ? 0 : $data->total_assist;
        })
        ->editColumn('total_goal_against', function ($data) use ($divisionPoints) {
            $goalConceded = isset($divisionPoints[$data->position][EventsEnum::GOAL_CONCEDED]) && $divisionPoints[$data->position][EventsEnum::GOAL_CONCEDED] ? $divisionPoints[$data->position][EventsEnum::GOAL_CONCEDED] : 0;

            return $goalConceded === 0 ? 0 : $data->total_goal_against;
        })
        ->editColumn('total_clean_sheet', function ($data) use ($divisionPoints) {
            $cleanSheet = isset($divisionPoints[$data->position][EventsEnum::CLEAN_SHEET]) && $divisionPoints[$data->position][EventsEnum::CLEAN_SHEET] ? $divisionPoints[$data->position][EventsEnum::CLEAN_SHEET] : 0;

            return $cleanSheet === 0 ? 0 : $data->total_clean_sheet;
        })
        ->editColumn('total_club_win', function ($data) use ($divisionPoints) {
            $clubWin = isset($divisionPoints[$data->position][EventsEnum::CLUB_WIN]) && $divisionPoints[$data->position][EventsEnum::CLUB_WIN] ? $divisionPoints[$data->position][EventsEnum::CLUB_WIN] : 0;

            return $clubWin === 0 ? 0 : $data->total_club_win;
        })
        ->editColumn('total_red_card', function ($data) use ($divisionPoints) {
            $redCard = isset($divisionPoints[$data->position][EventsEnum::RED_CARD]) && $divisionPoints[$data->position][EventsEnum::RED_CARD] ? $divisionPoints[$data->position][EventsEnum::RED_CARD] : 0;

            return $redCard === 0 ? 0 : $data->total_red_card;
        })
        ->editColumn('total_yellow_card', function ($data) use ($divisionPoints) {
            $yellowCard = isset($divisionPoints[$data->position][EventsEnum::YELLOW_CARD]) && $divisionPoints[$data->position][EventsEnum::YELLOW_CARD] ? $divisionPoints[$data->position][EventsEnum::YELLOW_CARD] : 0;

            return $yellowCard === 0 ? 0 : $data->total_yellow_card;
        })
        ->editColumn('total_penalty_missed', function ($data) use ($divisionPoints) {
            $penaltyMissed = isset($divisionPoints[$data->position][EventsEnum::PENALTY_MISSED]) && $divisionPoints[$data->position][EventsEnum::PENALTY_MISSED] ? $divisionPoints[$data->position][EventsEnum::PENALTY_MISSED] : 0;

            return $penaltyMissed === 0 ? 0 : $data->total_penalty_missed;
        })
        ->editColumn('total_penalty_saved', function ($data) use ($divisionPoints) {
            $penaltySave = isset($divisionPoints[$data->position][EventsEnum::PENALTY_SAVE]) && $divisionPoints[$data->position][EventsEnum::PENALTY_SAVE] ? $divisionPoints[$data->position][EventsEnum::PENALTY_SAVE] : 0;

            return $penaltySave === 0 ? 0 : $data->total_penalty_saved;
        })
        ->editColumn('total_own_goal', function ($data) use ($divisionPoints) {
            $ownGoal = isset($divisionPoints[$data->position][EventsEnum::OWN_GOAL]) && $divisionPoints[$data->position][EventsEnum::OWN_GOAL] ? $divisionPoints[$data->position][EventsEnum::OWN_GOAL] : 0;

            return $ownGoal === 0 ? 0 : $data->total_own_goal;
        })
        ->editColumn('total_goalkeeper_save', function ($data) use ($divisionPoints) {
            $goalkeeperSave = isset($divisionPoints[$data->position][EventsEnum::GOALKEEPER_SAVE_X5]) && $divisionPoints[$data->position][EventsEnum::GOALKEEPER_SAVE_X5] ? $divisionPoints[$data->position][EventsEnum::GOALKEEPER_SAVE_X5] : 0;

            return $goalkeeperSave === 0 ? 0 : $data->total_goalkeeper_save;
        })
        ->editColumn('team_manager_name', function ($data) {
            return $data->user_first_name.' '.$data->user_last_name;
        })
        ->addColumn('total', function ($data) use ($divisionPoints) {
            $goal = isset($divisionPoints[$data->position][EventsEnum::GOAL]) && $divisionPoints[$data->position][EventsEnum::GOAL] ? $divisionPoints[$data->position][EventsEnum::GOAL] : 0;
            $assist = isset($divisionPoints[$data->position][EventsEnum::ASSIST]) && $divisionPoints[$data->position][EventsEnum::ASSIST] ? $divisionPoints[$data->position][EventsEnum::ASSIST] : 0;
            $goalConceded = isset($divisionPoints[$data->position][EventsEnum::GOAL_CONCEDED]) && $divisionPoints[$data->position][EventsEnum::GOAL_CONCEDED] ? $divisionPoints[$data->position][EventsEnum::GOAL_CONCEDED] : 0;
            $cleanSheet = isset($divisionPoints[$data->position][EventsEnum::CLEAN_SHEET]) && $divisionPoints[$data->position][EventsEnum::CLEAN_SHEET] ? $divisionPoints[$data->position][EventsEnum::CLEAN_SHEET] : 0;
            $appearance = isset($divisionPoints[$data->position][EventsEnum::APPEARANCE]) && $divisionPoints[$data->position][EventsEnum::APPEARANCE] ? $divisionPoints[$data->position][EventsEnum::APPEARANCE] : 0;
            $clubWin = isset($divisionPoints[$data->position][EventsEnum::CLUB_WIN]) && $divisionPoints[$data->position][EventsEnum::CLUB_WIN] ? $divisionPoints[$data->position][EventsEnum::CLUB_WIN] : 0;
            $redCard = isset($divisionPoints[$data->position][EventsEnum::RED_CARD]) && $divisionPoints[$data->position][EventsEnum::RED_CARD] ? $divisionPoints[$data->position][EventsEnum::RED_CARD] : 0;
            $yellowCard = isset($divisionPoints[$data->position][EventsEnum::YELLOW_CARD]) && $divisionPoints[$data->position][EventsEnum::YELLOW_CARD] ? $divisionPoints[$data->position][EventsEnum::YELLOW_CARD] : 0;
            $ownGoal = isset($divisionPoints[$data->position][EventsEnum::OWN_GOAL]) && $divisionPoints[$data->position][EventsEnum::OWN_GOAL] ? $divisionPoints[$data->position][EventsEnum::OWN_GOAL] : 0;
            $penaltyMissed = isset($divisionPoints[$data->position][EventsEnum::PENALTY_MISSED]) && $divisionPoints[$data->position][EventsEnum::PENALTY_MISSED] ? $divisionPoints[$data->position][EventsEnum::PENALTY_MISSED] : 0;
            $penaltySave = isset($divisionPoints[$data->position][EventsEnum::PENALTY_SAVE]) && $divisionPoints[$data->position][EventsEnum::PENALTY_SAVE] ? $divisionPoints[$data->position][EventsEnum::PENALTY_SAVE] : 0;
            $goalkeeperSave = isset($divisionPoints[$data->position][EventsEnum::GOALKEEPER_SAVE_X5]) && $divisionPoints[$data->position][EventsEnum::GOALKEEPER_SAVE_X5] ? $divisionPoints[$data->position][EventsEnum::GOALKEEPER_SAVE_X5] : 0;

            $total = 0;
            $total += $goal * $data->total_goal;
            $total += $assist * $data->total_assist;
            $total += $goalConceded * $data->total_goal_against;
            $total += $cleanSheet * $data->total_clean_sheet;
            $total += $appearance * $data->total_game_played;
            $total += $clubWin * $data->total_club_win;
            $total += $yellowCard * $data->total_yellow_card;
            $total += $redCard * $data->total_red_card;
            $total += $ownGoal * $data->total_own_goal;
            $total += $penaltyMissed * $data->total_penalty_missed;
            $total += $penaltySave * $data->total_penalty_saved;
            $total += $goalkeeperSave * $data->total_goalkeeper_save;

            return $total;
        })
        ->filter(function ($query) {
        })
        ->addColumn('original_position', function ($data) use ($division) {
            return $division->getPositionShortCode(player_position_short($data->position));
        })

        ->addColumn('positionOrder', function ($data) use ($division, $positionOrder) {
            $pos = $division->getPositionShortCode(player_position_short($data->position));

            return isset($positionOrder[$pos]) ? $positionOrder[$pos] : 0;
        })
        ->addColumn('m_tshirt', function ($data) use ($division) {
            $position = $division->getPositionShortCode(player_position_short($data->position));

            $s3Url = config('fantasy.aws_url').'/tshirts/';
            if ($position == 'GK') {
                return $s3Url.strtoupper($data->club_name).'/GK.png';
            } else {
                return $s3Url.strtoupper($data->club_name).'/player.png';
            }
        })
        ->addColumn('m_position', function ($data) use ($division) {
            return $position = $division->getPositionShortCode(player_position_short($data->position));
        })
        ->rawColumns(['position', 'player_club_name', 'team_manager_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Player $model)
    {
        $division = request('division');

        $currentSeason = Season::find(Season::getLatestSeason());

        $season = $currentSeason->firstFixturePlayed() ? $currentSeason : Season::find(Season::getPreviousSeason());
        $teamIds = $division->divisionTeams->pluck('id');
        $playersId = TeamPlayerContract::whereIn('team_id', $teamIds)
        ->whereNull('team_player_contracts.end_date')->pluck('player_id');

        $players = $model::leftJoin('fixture_stats as fixture_stats_for_stats', function ($join) use ($season) {
            $join->on('fixture_stats_for_stats.player_id', '=', 'players.id');
            $join->whereIn('fixture_stats_for_stats.fixture_id',
                    function ($query) use ($season) {
                        $query->select('id')
                        ->from('fixtures')
                        ->where('fixtures.competition', CompetitionEnum::PREMIER_LEAGUE)
                        ->where('season_id', $season->id);
                    });
        })
                ->leftJoin('fixtures', function ($join) {
                    $join->on('fixtures.id', '=', 'fixture_stats_for_stats.fixture_id');
                })
                ->join('player_contracts', 'player_contracts.player_id', '=', 'players.id')
                ->leftJoin('player_status', function ($join) {
                    $join->on('player_status.player_id', '=', 'players.id')
                        ->where(function ($query) {
                            $query->whereNull('player_status.end_date')
                            ->orWhereDate('player_status.end_date', '>=', now()->toDateString());
                        });
                })
                ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                ->leftJoin(DB::raw("team_player_contracts INNER JOIN teams ON teams.id = team_player_contracts.team_id AND team_player_contracts.end_date IS NULL INNER JOIN transfers
                    ON transfers.id = (SELECT id FROM transfers WHERE transfers.player_in = team_player_contracts.player_id AND teams.id = transfers.team_id ORDER BY transfers.transfer_date DESC LIMIT 1) INNER JOIN division_teams ON division_teams.team_id = teams.id  AND division_teams.division_id = '".$division->id."'"),
                  function ($join) {
                      $join->on('team_player_contracts.player_id', '=', 'players.id');
                  })
                ->leftJoin('consumers', 'consumers.id', '=', 'teams.manager_id')
                ->leftJoin('users', 'users.id', '=', 'consumers.user_id')
                ->selectRaw('players.id,players.first_name as player_first_name,players.last_name as player_last_name,clubs.id as club_id,clubs.short_code as club_name,player_status.status as player_status,player_contracts.position,teams.id as team_id,teams.name as team_name,users.first_name as user_first_name,users.last_name as user_last_name,transfers.transfer_value as bought_price,clubs.short_code,team_player_contracts.id as team_player_contract_id,
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
                ->where('player_contracts.is_active', true)
                ->whereNull('player_contracts.end_date')
                ->where('clubs.is_premier', true)
                ->whereIn('players.id', $playersId);
        if (request()->has('position')) {
            $position = request('position');

            if ($position == AllPositionEnum::DEFENDER) {
                $players = $players->where(function ($query) {
                    $query->orwhere('player_contracts.position', AllPositionEnum::CENTREBACK)
                                      ->orWhere('player_contracts.position', AllPositionEnum::FULLBACK);
                });
            } elseif ($position == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
                $players = $players->where('player_contracts.position', AllPositionEnum::DEFENSIVE_MIDFIELDER);
            } elseif ($position == AllPositionEnum::MIDFIELDER) {
                if ($division->getOptionValue('defensive_midfields') != 'Yes') {
                    $players = $players->where(function ($query) {
                        $query->orwhere('player_contracts.position', AllPositionEnum::DEFENSIVE_MIDFIELDER)
                                      ->orWhere('player_contracts.position', AllPositionEnum::MIDFIELDER);
                    });
                } else {
                    $players = $players->where('player_contracts.position', AllPositionEnum::MIDFIELDER);
                }
            } else {
                $players = $players->where('player_contracts.position', $position);
            }
        }
        if (request('club')) {
            $players = $players->where('clubs.id', request('club'));
        }

        return $players->groupBy('players.id', 'clubs.id', 'clubs.name', 'player_status.status', 'player_contracts.position', 'teams.id', 'teams.name', 'transfers.transfer_value', 'clubs.short_code', 'team_player_contracts.id');
    }
}
