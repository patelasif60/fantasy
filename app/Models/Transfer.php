<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    // public function getTransferDateAttribute($value)
    // {
    //     return Carbon::parse($value)->format(config('fantasy.time.format'));
    // }

    // public function setTransferDateAttribute($value)
    // {
    //     $this->attributes['transfer_date'] = Carbon::createFromFormat(config('fantasy.time.format'), $value)->format(config('fantasy.db.datetime.format'));
    // }

    public function playerIn()
    {
        return $this->hasOne(Player::class, 'id', 'player_in');
    }

    public function playerOut()
    {
        return $this->hasOne(Player::class, 'id', 'player_out');
    }
}
