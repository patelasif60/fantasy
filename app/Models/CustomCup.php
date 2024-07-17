<?php

namespace App\Models;

use App\Enums\CustomCupStatusEnum;
use Illuminate\Database\Eloquent\Model;

class CustomCup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var bool
     */
    protected $casts = [
        'is_bye_random' => 'boolean',
    ];

    public function teams()
    {
        return $this->hasMany(CustomCupTeam::class);
    }

    public function rounds()
    {
        return $this->hasMany(CustomCupRound::class);
    }

    public function division()
    {
        return $this->hasOne(Division::class, 'id', 'division_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', CustomCupStatusEnum::ACTIVE);
    }
}
