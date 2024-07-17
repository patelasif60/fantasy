<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomCupRoundGameweek extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function gameweek()
    {
        return $this->belongsTo(GameWeek::class, 'gameweek_id');
    }
}
