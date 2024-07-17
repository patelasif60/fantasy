<?php

namespace App\Models;

use App\Enums\BadgeColorEnum;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
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
        'available_formations' => 'array',
        'auction_types' => 'array',
        'prize_packs' => 'array',
        'money_back_types' => 'array',
    ];

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function packagePoints()
    {
        return $this->hasMany(PackagePoint::class);
    }

    public function isDMFOn()
    {
        return ($this->getOptionValue('defensive_midfields') == 'No') ? false : true;
    }

    public function isMergeDefendersOn()
    {
        return ($this->getOptionValue('merge_defenders') == 'No') ? false : true;
    }

    public function getOptionValue($columnName, $events = null)
    {
        if (is_null($events)) {
            if (! is_null($this->$columnName)) {
                return $this->$columnName;
            }

            return $this->$columnName;
        }

        foreach ($this->packagePoints as $key => $value) {
            if ($value->events == $events && ! is_null($value->$columnName)) {
                return $value->$columnName;
            }
        }
    }

    public function scopeGetFree($query)
    {
        return $query->where('price', 0)->first();
    }

    public function badgeColor()
    {
        if ($this->badge_color == BadgeColorEnum::GREEN) {
            return 'green';
        }
        if ($this->badge_color == BadgeColorEnum::SILVER) {
            return 'silver';
        }

        return 'orange';
    }
}
