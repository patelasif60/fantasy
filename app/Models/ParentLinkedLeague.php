<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentLinkedLeague extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function childLinkedLeagues()
    {
        return $this->hasMany(ChildLinkedLeague::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
