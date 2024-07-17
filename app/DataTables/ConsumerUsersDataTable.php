<?php

namespace App\DataTables;

use App\Enums\Role\RoleEnum;
use App\Models\User;
use Yajra\DataTables\Services\DataTable;

class ConsumerUsersDataTable extends DataTable
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
            ->editColumn('last_login_at', function ($user) {
                if ($user->last_login_at) {
                    return carbon_format_to_time($user->last_login_at);
                }

                return '-';
            })
            ->filter(function ($query) {
                // Check for the presence of search term in request.
                $query->when(request()->has('term'), function ($query) {
                    return $query->where(function ($query) {
                        $query->where('first_name', 'like', '%'.escape_like(request('term')).'%')
                            ->orWhere('last_name', 'like', '%'.escape_like(request('term')).'%')
                            ->orWhere('email', 'like', '%'.escape_like(request('term')).'%');
                    });
                });
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model::role(RoleEnum::USER)->with('consumer')->select(
            'id',
            'first_name',
            'last_name',
            'email',
            'status',
            'last_login_at',
            'created_at',
            'updated_at'
        );
    }
}
