<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionPaymentSelectedTeam extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'manager_id',   'division_id',  'amount', 'token', 'teams',
    ];
}
