<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupersubGuideCounter extends Model
{
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'counter' => 'integer',
    ];
}
