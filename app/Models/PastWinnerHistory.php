<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PastWinnerHistory extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }
}
