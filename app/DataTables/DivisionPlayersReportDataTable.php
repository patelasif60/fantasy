<?php

namespace App\DataTables;

use App\Enums\PlayerContractPositionEnum;
use App\Enums\TransferTypeEnum;
use App\Enums\YesNoEnum;
use App\Models\Club;
use App\Models\SupersubTeamPlayerContract;
use App\Models\TeamPlayerContract;
use Yajra\DataTables\Services\DataTable;

class DivisionPlayersReportDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
        ->editColumn('position', function ($data) {
            $position = player_position_short($data->position);

            if ($data->position == PlayerContractPositionEnum::DEFENSIVE_MIDFIELDER) {
                if (! is_null($data->division_merge_defenders)) {
                    $mergeDefenders = $data->division_merge_defenders;
                } else {
                    $mergeDefenders = $data->package_merge_defenders;
                }

                if ($mergeDefenders == YesNoEnum::YES) {
                    $position = 'DF';
                }
            }

            return '<div class="player-wrapper"><div><span class="custom-badge custom-badge-lg is-square is-'.strtolower($position).'">'.$position.'</span></div><div><div>'.get_player_name('firstNameFirstCharAndFullLastName', $data->player_first_name, $data->player_last_name).'</div><div class="small">'.$data->club_name.'</div></div>';
        })
        ->editColumn('team_manager_name', function ($data) {
            return '<div class="player-wrapper"><div><div>'.$data->team_name.'</div><div class="small">'.$data->user_first_name.' '.$data->user_last_name.'</div></div></div>';
        })
        ->addColumn('next_fixture', function ($data) {
            $nextFixture = Club::find($data->club_id)->nextFixture();
            if (isset($nextFixture)) {
                $playerClubId = $data->club_id;

                if ($playerClubId == $nextFixture->home_club_id) {
                    $fixture['type'] = 'H';
                    $fixture['short_code'] = $nextFixture->away_team->short_code;
                } else {
                    $fixture['type'] = 'A';
                    $fixture['short_code'] = $nextFixture->home_team->short_code;
                }
                $fixture['date_time'] = $nextFixture->date_time;

                $fixture['time'] = carbon_format_to_time_for_fixture($nextFixture->date_time);
                $fixture['str_date'] = carbon_format_to_date_for_fixture_format1($nextFixture->date_time);

                //check player in team or not
                $chkSuperSubEntry = SupersubTeamPlayerContract::where('team_id', $data->team_id)
                                        ->where('player_id', $data->player_id)
                                        ->where('start_date', $nextFixture->date_time)
                                        ->where('is_applied', false)
                                        ->first();

                $inLineup = '';
                if (isset($chkSuperSubEntry)) {
                    if ($chkSuperSubEntry->is_active == 1) {
                        $inLineup = 'in';
                    } else {
                        $inLineup = 'out';
                    }
                }
                $fixture['in_lineup'] = $inLineup;

                $nextFixture = $fixture;
            }

            return $nextFixture;
        })
        ->filter(function ($query) {
            // Check for the presence of search division_id in request.
            $query->when(request()->has('division_id'), function ($query) {
                return $query->where('divisions.id', request('division_id'));
            });

            // Check for the presence of player position in request.
            $query->when(request()->has('position'), function ($query) {
                return $query->where('player_contracts.position', 'like', '%'.escape_like(request('position')).'%');
            });

            // Check for the presence of player club in request.
            $query->when(request()->has('club'), function ($query) {
                return $query->where('clubs.id', request('club'));
            });
        })
        ->rawColumns(['position', 'player_club_name', 'team_manager_name']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\TeamPlayerContract $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TeamPlayerContract $model)
    {
        return $model::join('teams', 'teams.id', '=', 'team_player_contracts.team_id')
            ->join('division_teams', 'division_teams.team_id', '=', 'teams.id')
            ->join('divisions', 'divisions.id', '=', 'division_teams.division_id')
            ->join('packages', 'packages.id', '=', 'divisions.package_id')
            ->join('players', 'players.id', '=', 'team_player_contracts.player_id')
            ->join('player_contracts', 'players.id', '=', 'player_contracts.player_id')
            ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
            ->join('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->join('users', 'users.id', '=', 'consumers.user_id')
            ->leftJoin('team_player_points', function ($join) {
                $join->on('players.id', '=', 'team_player_points.player_id');
                $join->on('teams.id', '=', 'team_player_points.team_id');
            })
            ->leftJoin('transfers', function ($join) {
                $join->on('transfers.player_in', '=', 'team_player_contracts.player_id');
                $join->on('teams.id', '=', 'transfers.team_id');
                $join->where('transfers.transfer_type', '=', TransferTypeEnum::SEALEDBIDS);
            })
            ->selectRaw('team_player_points.team_id,team_player_points.player_id,player_contracts.position,players.first_name as player_first_name,players.last_name as player_last_name,users.first_name as user_first_name,users.last_name as user_last_name,clubs.id as club_id,clubs.name as club_name,teams.name as team_name,transfers.transfer_value,divisions.merge_defenders as division_merge_defenders,packages.merge_defenders as package_merge_defenders,sum(team_player_points.goal) goal,sum(team_player_points.assist) assist,sum(team_player_points.clean_sheet) clean_sheet,sum(team_player_points.conceded) conceded,sum(team_player_points.appearance) appearance,sum(team_player_points.total) total')
            ->whereNull('team_player_contracts.end_date')
            ->orderByRaw("FIELD(player_contracts.position, 'Goalkeeper (GK)','Full-back (FB)','Centre-back (CB)','Defensive Midfielder (DMF)','Midfielder (MF)','Striker (ST)')")
            ->groupBy('team_player_points.team_id', 'team_player_points.player_id', 'player_contracts.position', 'players.first_name', 'players.last_name', 'users.first_name', 'users.last_name', 'clubs.id', 'clubs.name', 'teams.name', 'transfers.transfer_value', 'divisions.merge_defenders', 'packages.merge_defenders');
    }
}
