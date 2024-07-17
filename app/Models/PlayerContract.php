<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerContract extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('end_date');
    }
}
