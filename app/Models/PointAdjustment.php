<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointAdjustment extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function getNoteAttribute()
    {
        return mb_strimwidth($this->attributes['note'], 0, 40, '...');
    }
}
