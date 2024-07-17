<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChildLinkedLeague extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function parentLinkedLeague()
    {
        return $this->belongsTo(ParentLinkedLeague::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
