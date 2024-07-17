<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionTeam extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    public $timestamps = false;

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function season()
    {
        return $this->hasOne(Season::class, 'id', 'season_id');
    }

    public function scopeNotPaid($query)
    {
        return $query->whereNull('payment_id');
    }
}
