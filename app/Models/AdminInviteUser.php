<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminInviteUser extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'invited_at' => 'date',
        'invited_accepted_at' => 'date',
    ];

    /**
     * Get the user that owns the invite.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
