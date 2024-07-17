<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InviteCode extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    /**
     * Get the consumer data associated with the user,
     * in case the user has registered as a consumer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
