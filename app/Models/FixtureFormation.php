<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FixtureFormation extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
    ];
}
