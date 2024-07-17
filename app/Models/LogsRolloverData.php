<?php

namespace App\Models;

use App\Mail\Logs\RolloverLogCompletedEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class LogsRolloverData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs_rollover_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public static function begin()
    {
        return static::create([
            'start_time' => now(),
            'status' => 'started',
            'end_time' => null,
            'created_by' => auth()->check() ? auth()->id() : User::where('email',config('fantasy.rollover_user'))->first()->id,
        ]);
    }

    public function end()
    {
        $this->update([
            'status' => 'completed',
            'end_time' => now(),
        ]);

        //Send email to user
        Mail::to($this->user)->send(new RolloverLogCompletedEmail($this));

        return $this;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
