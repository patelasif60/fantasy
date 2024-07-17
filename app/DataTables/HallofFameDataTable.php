<?php

namespace App\DataTables;

use App\Enums\EventsEnum;
use App\Enums\PlayerContractPosition\AllPositionEnum;
use App\Enums\PositionsEnum;
use App\Models\PlayerContract;
use App\Services\DivisionService;
use DB;
use Yajra\DataTables\Services\DataTable;

class HallofFameDataTable extends DataTable
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

        return datatables($query)
        ->addColumn('player', function ($data) {
            return get_player_name('firstNameFirstCharAndFullLastName', $data->first_name, $data->last_name);
        })
        ->editColumn('position', function ($data) use ($division) {
            $position = $division->getPositionShortCode(player_position_short($data->position));

            return $position;
        })
        ->addColumn('clubs', function ($data) {
            return $data->cname;
        })
        ->addColumn('clubs_short_code', function ($data) {
            return strtolower($data->short_code);
        })
         ->addColumn('played', function ($data) {
             return $data->played;
         })
        ->editColumn('Season', function ($data) use ($division) {
            return $data->sname;
        })
        ->editColumn('goal', function ($data) use ($divisionPoints) {
            return  $data->goal;
        })
        ->editColumn('assist', function ($data) use ($divisionPoints) {
            return  $data->assist;
        })
        ->editColumn('goal_conceded', function ($data) use ($divisionPoints) {
            return  $data->goal_conceded;
        })
        ->editColumn('clean_sheet', function ($data) use ($divisionPoints) {
            return $data->clean_sheet;
        })
        ->editColumn('appearance', function ($data) use ($divisionPoints) {
            return  $data->appearance;
            //return  $appearance * $data->appearance;
        })
        ->editColumn('total', function ($data) use ($divisionPoints) {
            $goal = isset($divisionPoints[$data->position][EventsEnum::GOAL]) && $divisionPoints[$data->position][EventsEnum::GOAL] ? $divisionPoints[$data->position][EventsEnum::GOAL] : 0;

            $assist = isset($divisionPoints[$data->position][EventsEnum::ASSIST]) && $divisionPoints[$data->position][EventsEnum::ASSIST] ? $divisionPoints[$data->position][EventsEnum::ASSIST] : 0;

            $goalConceded = isset($divisionPoints[$data->position][EventsEnum::GOAL_CONCEDED]) && $divisionPoints[$data->position][EventsEnum::GOAL_CONCEDED] ? $divisionPoints[$data->position][EventsEnum::GOAL_CONCEDED] : 0;

            $cleanSheet = isset($divisionPoints[$data->position][EventsEnum::CLEAN_SHEET]) && $divisionPoints[$data->position][EventsEnum::CLEAN_SHEET] ? $divisionPoints[$data->position][EventsEnum::CLEAN_SHEET] : 0;

            $appearance = isset($divisionPoints[$data->position][EventsEnum::APPEARANCE]) && $divisionPoints[$data->position][EventsEnum::APPEARANCE] ? $divisionPoints[$data->position][EventsEnum::APPEARANCE] : 0;

            return $data->goal * $goal + $data->assist * $assist + $data->clean_sheet * $cleanSheet + $data->goal_conceded * $goalConceded + $data->appearance * $appearance;
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PlayerContract $model)
    {
        $division = request('division');
        $players = DB::table('history_stats')
                    ->join('players', 'players.id', '=', 'history_stats.player_id')
                    ->join('clubs', 'clubs.id', '=', 'history_stats.club_id')
                    ->join('seasons', 'seasons.id', '=', 'history_stats.season_id')
                    ->selectRaw('clubs.short_name,clubs.short_code,goal,assist,goal_conceded,clean_sheet,appearance,played,players.last_name,players.first_name,seasons.name as sname , clubs.name as cname,(select player_contracts.`position` from `player_contracts` where `player_contracts`.`player_id` = `history_stats`.`player_id` and end_date is null ) as position,players.id as pid')

                    ->orderBy('history_stats.total', 'desc')
                    ->orderBy('seasons.id', 'desc')
                    ->orderBy('players.last_name', 'asc');

        // if (request()->has('position')) {
        //     $position = request('position');
        //     if ($position == AllPositionEnum::DEFENDER) {
        //         $players = $players->where(function ($query) {
        //             $query->orwhere('pc.position', AllPositionEnum::CENTREBACK)
        //                               ->orWhere('pc.position', AllPositionEnum::FULLBACK);
        //         });
        //     } elseif ($position == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
        //         $players = $players->where('pc.position', AllPositionEnum::DEFENSIVE_MIDFIELDER);
        //     } elseif ($position == AllPositionEnum::MIDFIELDER) {
        //         if ($division->getOptionValue('defensive_midfields') != 'Yes') {
        //             $players = $players->where(function ($query) {
        //                 $query->orwhere('pc.position', AllPositionEnum::DEFENSIVE_MIDFIELDER)
        //                               ->orWhere('pc.position', AllPositionEnum::MIDFIELDER);
        //             });
        //         } else {
        //             $players = $players->where('pc.position', AllPositionEnum::MIDFIELDER);
        //         }
        //     } else {
        //         $players = $players->where('pc.position', $position);
        //     }
        // }
        if (request('club')) {
            $players = $players->where('clubs.id', request('club'));
        }
        if (request('season')) {
            $players = $players->where('history_stats.season_id', request('season'));
        }

        return $players;
    }
}
