<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SealedBidTransfer extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_process' => 'boolean',
    ];

    /**
     * Get the operator data associated with the user,
     * in case the user has registered as consumer.
     */
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function playerOut()
    {
        return $this->belongsTo(Player::class, 'player_out', 'id');
    }

    public function playerIn()
    {
        return $this->belongsTo(Player::class, 'player_in', 'id');
    }

    public function round()
    {
        return $this->belongsTo(TransferRound::class, 'transfer_rounds_id', 'id');
    }
}
