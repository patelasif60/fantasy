<?php

namespace App\DataTables;

use App\Enums\HistoryPeriodEnum;
use App\Enums\HistoryTransferTypeEnum;
use App\Models\Season;
use App\Models\Transfer;
use Carbon\Carbon;
use DB;
use Yajra\DataTables\Services\DataTable;

class ChangeHistoryDataTable extends DataTable
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

        return datatables($query)
                ->addColumn('player_in_position', function ($data) use ($division) {
                    return $division->getPositionShortCode(player_position_short($data->player_in_position));
                })
                ->addColumn('player_out_position', function ($data) use ($division) {
                    return $division->getPositionShortCode(player_position_short($data->player_out_position));
                })
                ->addColumn('transfer_date', function ($data) {
                    return carbon_format_to_datetime_for_fixture($data->transfer_date);
                });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Transfer $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transfer $model)
    {
        $division = request('division');

        $transfer = $model::join('teams', 'teams.id', '=', 'transfers.team_id')
            ->join('division_teams', 'division_teams.team_id', '=', 'teams.id')
            ->leftJoin('players as players_in', 'players_in.id', '=', 'transfers.player_in')
            ->leftJoin('players as players_out', 'players_out.id', '=', 'transfers.player_out')
             ->leftJoin('player_contracts as player_contracts_in', function ($join) {
                 $join->on('player_contracts_in.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players_in.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date))))'));
             })
             ->leftJoin('player_contracts as player_contracts_out', function ($join) {
                 $join->on('player_contracts_out.id', '=', DB::raw('(SELECT id FROM player_contracts WHERE player_contracts.player_id = players_out.id AND( ( ( DATE(transfers.transfer_date) >= player_contracts.start_date AND DATE(transfers.transfer_date) <= player_contracts.end_date ) AND player_contracts.end_date IS NOT NULL ) OR ( player_contracts.is_active = 1 AND player_contracts.end_date IS NULL AND player_contracts.start_date <= DATE(transfers.transfer_date))))'));
             })
            ->leftJoin('clubs as player_in_club', 'player_in_club.id', '=', 'player_contracts_in.club_id')
            ->leftJoin('clubs as player_out_club', 'player_out_club.id', '=', 'player_contracts_out.club_id')
            ->leftJoin('consumers', 'consumers.id', '=', 'teams.manager_id')
            ->leftJoin('users', 'users.id', '=', 'consumers.user_id')
            ->selectRaw('transfers.transfer_date,transfers.transfer_value,teams.name,teams.id,transfers.transfer_type,players_in.first_name as player_in_first_name,players_in.last_name as player_in_last_name,players_out.first_name as player_out_first_name,players_out.last_name as player_out_last_name,users.first_name as user_first_name,users.last_name as user_last_name,players_in.short_code as player_in_short_code,players_out.short_code as player_out_short_code,player_in_club.short_code as player_in_club_name,player_out_club.short_code as player_out_club_name,player_contracts_in.position as player_in_position,player_contracts_out.position as player_out_position,IF(transfers.transfer_type = "budgetcorrection", IF(transfers.transfer_value > 0, transfers.transfer_value, "Notrequired"), transfers.transfer_value ) AS transfer_type_value')
            ->where('division_teams.division_id', $division->id)
            ->whereIn('transfers.transfer_type', collect(HistoryTransferTypeEnum::toArray())->values());

        if (request('type')) {
            $transfer = $transfer->where('transfers.transfer_type', request('type'));
        }

        if (request('period')) {
            $endDate = Carbon::now()->format(config('fantasy.db.datetime.format'));

            if (request('period') == HistoryPeriodEnum::SEVEN_DAYS) {
                $startDate = Carbon::now()->subDays(7)->format(config('fantasy.db.datetime.format'));
            } elseif (request('period') == HistoryPeriodEnum::THIRTY_DAYS) {
                $startDate = Carbon::now()->subDays(30)->format(config('fantasy.db.datetime.format'));
            } elseif (request('period') == HistoryPeriodEnum::SEASON) {
                $latestSeason = Season::orderBy('id', 'desc')->first();
                $startDate = $latestSeason->start_at;
                $endDate = $latestSeason->end_at;
            }

            $transfer = $transfer->where('transfers.transfer_date', '>=', $startDate)->where('transfers.transfer_date', '<=', $endDate);
        }

        return $transfer->groupBy('transfers.id', 'teams.name', 'player_in_first_name', 'player_in_last_name', 'player_out_first_name', 'player_out_last_name', 'user_first_name', 'user_last_name', 'player_in_short_code', 'player_out_short_code', 'player_in_club_name', 'player_out_club_name', 'player_in_position', 'player_out_position')
                ->havingRaw('transfer_type_value != "Notrequired"')
                ->orHavingRaw('transfer_type_value IS NULL')
                ->orderBy('transfers.transfer_date', 'desc');
    }
}
