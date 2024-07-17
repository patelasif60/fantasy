<?php

namespace App\Models;

use App\Enums\BadgeColorEnum;
use Illuminate\Database\Eloquent\Model;

class PrizePack extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

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
