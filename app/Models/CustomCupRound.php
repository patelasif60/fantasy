<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomCupRound extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function gameWeeks()
    {
        return $this->hasMany(CustomCupRoundGameweek::class);
    }

    public function customCup()
    {
        return $this->belongsTo(CustomCup::class);
    }

    public function fixtures()
    {
        return $this->hasMany(CustomCupFixture::class, 'custom_cup_round_id');
    }
}
