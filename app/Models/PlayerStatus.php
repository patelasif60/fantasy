<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerStatus extends Model
{
    protected $table = 'player_status';
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
