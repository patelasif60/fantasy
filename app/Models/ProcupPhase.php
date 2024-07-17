<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcupPhase extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function procupFixtures()
    {
        return $this->hasMany(ProcupFixture::class, 'procup_phase_id');
    }

    public function notWinnerFixtures()
    {
        return $this->procupFixtures()->whereNull('winner');
    }
}
