<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferTiePreference extends Model
{
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
