<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureEventType extends Model
{
    protected $table = 'fixture_event_type';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
}
