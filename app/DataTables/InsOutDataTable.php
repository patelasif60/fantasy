<?php

namespace App\DataTables;

use DB;
use App\Models\Season;
use App\Enums\PositionsEnum;
use App\Models\PlayerContract;
use Yajra\DataTables\Services\DataTable;
use App\Enums\PlayerContractPosition\AllPositionEnum;

class InsOutDataTable extends DataTable
{
    public $division;
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

        return datatables($query)
        ->editColumn('position', function ($data) use ($division) {
            $position = $division->getPositionShortCode(player_position_short($data->position));

            return $position;
        })
        ->addColumn('TransferDate', function ($data) {
            return carbon_format_to_date($data->start_date);
        })
         ->addColumn('player', function ($data) {
             return get_player_name('firstNameFirstCharAndFullLastName', $data->first_name, $data->last_name);
         })
        ->editColumn('outfrom', function ($data) use ($division) {
            // $tshirt = strtolower($data->outshortcode).'_player';
            // if ($division->getPositionShortCode(player_position_short($data->position)) == 'GK') {
            //     $tshirt = strtolower($data->outshortcode).'_gk';
            // }

            return $data->outfrom;
        })
        ->editColumn('infrom', function ($data) use ($division) {
            // $tshirt = strtolower($data->inshortcode).'_player';
            // if ($division->getPositionShortCode(player_position_short($data->position)) == 'GK') {
            //     $tshirt = strtolower($data->inshortcode).'_gk';
            // }

            return $data->infrom;
        })
        ->editColumn('m_tshirt_out', function ($data) use ($division) {
            $position = $division->getPositionShortCode(player_position_short($data->position));

            return player_tshirt($data->outshortcode, $position);
            // $s3Url = config('fantasy.aws_url').'/tshirts/';
            // if ($position == 'GK') {
            //     return $s3Url.strtoupper($data->outshortcode).'/GK.png';
            // } else {
            //     return $s3Url.strtoupper($data->outshortcode).'/player.png';
            // }
        })
        ->editColumn('m_tshirt_in', function ($data) use ($division) {
            $position = $division->getPositionShortCode(player_position_short($data->position));

            return player_tshirt($data->inshortcode, $position);
            // $s3Url = config('fantasy.aws_url').'/tshirts/';
            // if ($position == 'GK') {
            //     return $s3Url.strtoupper($data->inshortcode).'/GK.png';
            // } else {
            //     return $s3Url.strtoupper($data->inshortcode).'/player.png';
            // }
        })
        ->addColumn('dtstr', function ($data) {
            return strtotime($data->start_date);
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
        // $season = Season::find(Season::getLatestSeason());
        // $seasonStartDate = $season ? $season->start_at : now();

        //For this static date check this tikcets
        //https://aecordigital.assembla.com/spaces/fantasyleague/tickets/realtime_cardwall?ticket=1517
        $seasonStartDate = '2020-09-01';
        $division = request('division');

        $players = DB::table('player_contracts AS pc')
                ->join('players', 'players.id', '=', 'pc.player_id')
                ->join('clubs', 'clubs.id', '=', 'pc.club_id')
                ->selectRaw('pc.`is_active`, pc.`club_id`,pc.id,pc.`player_id`,players.first_name,players.`last_name`,clubs.short_code,pc.`start_date` ,pc.`position`,pc.`end_date`,(SELECT clubs.`short_name` FROM clubs WHERE clubs.id = (SELECT player_contracts.`club_id` FROM player_contracts INNER JOIN clubs cb ON cb.id = player_contracts.club_id WHERE player_contracts.`player_id` = pc.player_id AND cb.`is_premier` = 1 AND player_contracts.`end_date` IN (pc.start_date,DATE_ADD(pc.start_date, INTERVAL -1 DAY)) limit 1)) AS outfrom ,(SELECT LOWER(clubs.`short_code`)  FROM clubs WHERE clubs.id = (SELECT player_contracts.`club_id` FROM player_contracts INNER JOIN clubs cb ON cb.id = player_contracts.club_id WHERE player_contracts.`player_id` = pc.player_id AND cb.`is_premier` = 1  AND player_contracts.`end_date` IN (pc.start_date,DATE_ADD(pc.start_date, INTERVAL -1 DAY)) limit 1)) AS outshortcode , clubs.`short_name` AS infrom ,LOWER(clubs.`short_code`) AS inshortcode')
                ->whereDate('pc.start_date', '>', $seasonStartDate)
                ->where('clubs.is_premier', true)
                ->where('pc.is_active', true)
                ->whereNull('pc.end_date')
                ->orderBy('pc.start_date', 'desc')
                ->orderBy('players.last_name', 'asc')
                ->orderBy('clubs.short_code', 'asc');

        if (request()->has('position')) {
            $position = request('position');

            if ($position == AllPositionEnum::DEFENDER) {
                $players = $players->where(function ($query) {
                    $query->orwhere('pc.position', AllPositionEnum::CENTREBACK)
                                      ->orWhere('pc.position', AllPositionEnum::FULLBACK);
                });
            } elseif ($position == AllPositionEnum::DEFENSIVE_MIDFIELDER) {
                $players = $players->where('pc.position', AllPositionEnum::DEFENSIVE_MIDFIELDER);
            } elseif ($position == AllPositionEnum::MIDFIELDER) {
                if ($division->getOptionValue('defensive_midfields') != 'Yes') {
                    $players = $players->where(function ($query) {
                        $query->orwhere('pc.position', AllPositionEnum::DEFENSIVE_MIDFIELDER)
                                      ->orWhere('pc.position', AllPositionEnum::MIDFIELDER);
                    });
                } else {
                    $players = $players->where('pc.position', AllPositionEnum::MIDFIELDER);
                }
            } else {
                $players = $players->where('pc.position', $position);
            }
        }
        if (request('club')) {
            $players = $players->where('clubs.id', request('club'));
        }

        return $players;
    }
}