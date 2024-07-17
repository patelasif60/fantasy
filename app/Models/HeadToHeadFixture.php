<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadToHeadFixture extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The league phase that the fixture item belongs to.
     *
     * @return Gameweek
     */
    public function leaguePhase()
    {
        return $this->hasOne(LeaguePhase::class);
    }
}
