<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionTiePreference extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'auction_tie_preferences';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
