<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoryStats extends Model
{
    protected $guarded = ['id'];
    protected $table = 'history_stats';

    public function season()
    {
        return $this->belongsTo(Season::class);
    }
}
