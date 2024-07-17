<?php

namespace App\DataTables;

use App\Models\PlayerStatus;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;

class InjuredPlayersDataTable extends DataTable
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

        $positionOrder = $division->getPositionOrder();

        return datatables($query)
                ->editColumn('position', function ($data) use ($division) {
                    $position = $division->getPositionShortCode(player_position_short($data->position));

                    $tshirt = strtolower($data->club).'_player';
                    if ($position == 'GK') {
                        $tshirt = strtolower($data->club).'_gk';
                    }

                    $status = '';
                    if ($data->status) {
                        $playerStatus = implode('', explode(' ', trim(strtolower($data->status))));
                        $status = '<img src="/assets/frontend/img/status/'.$playerStatus.'.svg" draggable="false" title="'.$data->player_status_description.'" class="status-img ml-2">';
                    }

                    return '<div class="player-wrapper js-player-details cursor-pointer min-width-auto" data-id="'.$data->id.'" data-name="'.$data->first_name.' '.$data->surname.'" data-club="'.$data->club_name.'"><div><span class="custom-badge custom-badge-lg is-square is-'.strtolower($position).'">'.$position.'</span></div><div>';
                })
                ->editColumn('m_position', function ($data) use ($division) {
                    $position = $division->getPositionShortCode(player_position_short($data->position));

                    return $position;
                })
                ->editColumn('m_status_img', function ($data) use ($division) {
                    $position = $division->getPositionShortCode(player_position_short($data->position));

                    $tshirt = strtolower($data->club).'_player';
                    if ($position == 'GK') {
                        $tshirt = strtolower($data->club).'_gk';
                    }

                    $status = '';
                    if ($data->status) {
                        $playerStatus = implode('', explode(' ', trim(strtolower($data->status))));
                        $status = 'https://fantasyleague.com/assets/frontend/img/status/'.$playerStatus.'.svg';
                    }

                    return $status;
                })
                ->editColumn('m_tshirt_img', function ($data) use ($division) {
                    $s3Url = config('fantasy.aws_url').'/tshirts/';

                    return $s3Url.$data->club.'/player.png';
                })
                ->addColumn('player', function ($data) use ($division) {
                    $position = $division->getPositionShortCode(player_position_short($data->position));

                    $tshirt = strtolower($data->club).'_player';
                    if ($position == 'GK') {
                        $tshirt = strtolower($data->club).'_gk';
                    }

                    $status = '';
                    if ($data->status) {
                        $playerStatus = implode('', explode(' ', trim(strtolower($data->status))));
                        $status = '<img src="/assets/frontend/img/status/'.$playerStatus.'.svg" draggable="false" title="'.$data->player_status_description.'" class="status-img ml-2">';
                    }

                    return '<div class="player-tshirt icon-18 '.$tshirt.' mr-1"></div>'.get_player_name('firstNameFirstCharAndFullLastName', $data->first_name, $data->surname).' '.$status.' </div>';
                })
                ->editColumn('end_date', function ($data) {
                    if ($data->end_date) {
                        return carbon_format_to_date($data->end_date);
                    }
                })
                ->addColumn('srank', function ($data) use ($division) {
                    if (strtolower($data->status) == 'injured') {
                        return 1;
                    } elseif (strtolower($data->status) == 'suspended') {
                        return 2;
                    } elseif (strtolower($data->status) == 'international duty') {
                        return 3;
                    } elseif (strtolower($data->status) == 'doubtful') {
                        return 4;
                    } elseif (strtolower($data->status) == 'late fitness test') {
                        return 5;
                    }
                })
                ->addColumn('year', function ($data) use ($division) {
                    if (trim($data->end_date) != '') {
                        return Carbon::parse($data->end_date)->format('Y');
                    }
                })
                ->addColumn('month', function ($data) use ($division) {
                    if (trim($data->end_date) != '') {
                        return Carbon::parse($data->end_date)->format('m');
                    }
                })
                ->addColumn('day', function ($data) use ($division) {
                    if (trim($data->end_date) != '') {
                        return Carbon::parse($data->end_date)->format('d');
                    }
                })
                ->addColumn('positionOrder', function ($data) use ($division, $positionOrder) {
                    $pos = $division->getPositionShortCode(player_position_short($data->position));

                    return isset($positionOrder[$pos]) ? $positionOrder[$pos] : 0;
                })
                ->rawColumns(['position', 'initial', 'status', 'player']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PointAdjustment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PlayerStatus $model)
    {
        $division = request('division');

        return $model->join('players', 'players.id', '=', 'player_status.player_id')
                    ->join('player_contracts', function ($join) {
                        return $join->on('player_contracts.player_id', '=', 'player_status.player_id')
                                        ->where('player_contracts.start_date', '<=', Carbon::now())
                                        ->where(function ($query) {
                                            return $query->whereNull('player_contracts.end_date')
                                                        ->orWhere('player_contracts.end_date', '>=', Carbon::now());
                                        });
                    })
                    ->join('clubs', 'clubs.id', '=', 'player_contracts.club_id')
                    // ->join('team_player_contracts', function($query){
                    //     return $query->on('player_status.player_id', '=', 'team_player_contracts.player_id')
                    //             ->where('team_player_contracts.start_date', '<=', Carbon::now())
                    //             ->whereNull('team_player_contracts.end_date');
                    // })
                    // ->join('division_teams', function($query) use ($division) {
                    //     return $query->on('team_player_contracts.team_id', 'division_teams.team_id')
                    //         ->where('division_teams.division_id', $division->id);
                    // })
                    ->where('player_status.start_date', '<=', Carbon::now())
                    ->where(function ($query) {
                        return $query->whereNull('player_status.end_date')
                            ->orWhere('player_status.end_date', '>=', Carbon::now());
                    })
                    ->selectRaw('
                        player_status.id, player_status.player_id, player_status.status, player_status.description, player_status.start_date, player_status.end_date,
                        players.first_name, players.last_name AS surname,
                        clubs.name, clubs.short_name, clubs.short_code AS club,
                        player_contracts.position AS position
                        ')
                    ->orderBy('position')
                    ->orderBy('club')
                    ->orderBy('last_name')
                    ->get();
    }
}
