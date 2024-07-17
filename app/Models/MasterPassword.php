<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPassword extends Model
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
        'used_at' => 'datetime',
    ];

    /**
     * Get the user that owns the password.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->whereNull('used_at')->where('created_at', '>=', now()->subMinutes(60));
    }

    public function markAsUsed()
    {
        $this->update([
            'used_at' => now(),
        ]);

        return $this;
    }
}
