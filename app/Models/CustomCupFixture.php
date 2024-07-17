<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomCupFixture extends Model
{
    protected $guarded = ['id'];

    public function gameweek()
    {
        return $this->belongsTo(GameWeek::class);
    }
}
