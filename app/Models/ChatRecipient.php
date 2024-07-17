<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRecipient extends Model
{
    /**
     * The attributes that are mass assignable.
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
        'is_read' => 'boolean',
    ];

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function consumer()
    {
        return $this->belongsTo(Consumer::class, 'receiver_id');
    }
}
