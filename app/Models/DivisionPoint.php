<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DivisionPoint extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
