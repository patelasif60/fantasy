<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureEventDetails extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function event()
    {
        return $this->belongsTo(FixtureEvent::class, 'event_id', 'id');
    }

    public function player()
    {
        return $this->hasOne(Player::class, 'id', 'field_value');
    }
}
