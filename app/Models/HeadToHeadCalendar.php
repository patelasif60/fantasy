<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadToHeadCalendar extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'head_to_head_calendar';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The gameweek that the calendar item belongs to.
     *
     * @return Gameweek
     */
    public function gameweek()
    {
        return $this->hasOne(Gameweek::class, 'number', 'number')->where('season_id', Season::getLatestSeason());
    }
}
