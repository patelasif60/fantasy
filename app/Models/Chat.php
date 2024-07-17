<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function chatRecipients()
    {
        return $this->hasMany(ChatRecipient::class);
    }

    public function consumer()
    {
        return $this->belongsTo(Consumer::class, 'sender_id');
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }
}
